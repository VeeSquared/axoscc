<?php
namespace App\Controller\v1;

use App\Controller\ApiController;
use App\Entity\PizzaOrder;
use App\Repository\PizzaOrderRepository;
use App\Entity\PizzaOrderLine;
use App\Repository\PizzaOrderLineRepository;
use App\Repository\PizzaCombinationRepository;
use App\Repository\PizzaSizeRepository;
use App\Repository\CustomerRepository;
use App\Repository\OrderStatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/v1")
 */
class PizzaOrderController extends ApiController
{
    /**************************************************************************
    * Begin Order                                                             *
    **************************************************************************/

    /**
    * @Route("/orders", methods="GET")
    */
    public function getPizzaOrders(PizzaOrderRepository $pizzaOrderRepository)
    {
        $pizzaOrders = $pizzaOrderRepository->transformAll();

        return $this->respond($pizzaOrders);
    }

    /**
    * @Route("/orders/{id}", methods="GET")
    */
    public function getPizzaOrder($id, PizzaOrderRepository $pizzaOrderRepository, EntityManagerInterface $em)
    {
        $pizzaOrder  = $pizzaOrderRepository->find($id);

        if (!$pizzaOrder) {
            return $this->respondNotFound();
        }

        $em->persist($pizzaOrder);
        $em->flush();

        return $this->respondCreated($pizzaOrderRepository->transform($pizzaOrder));
    }

    /**
    * @Route("/orders", methods="POST")
    */
    public function createPizzaOrder(Request $request, CustomerRepository $customerRepository, EntityManagerInterface $em)
    {
        $request = $this->transformJsonBody($request);

        if (! $request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        // validate the customer id
        if (! $request->get('customer_id')) {
            return $this->respondValidationError('Please provide a Customer ID!');
        }

        $customer  = $customerRepository->find($request->get('customer_id'));

        if (!$customer) {
            return $this->respondValidationError('Please provide a valid Customer ID');
        }

        $pizzaOrder = new PizzaOrder;
        $pizzaOrder->setCustomerId($request->get('customer_id'));
        $pizzaOrder->setOrderStatusId(2);
        $pizzaOrder->setTotalPriceDollar(0);
        $pizzaOrder->setTotalPricecent(0);
        $em->persist($pizzaOrder);
        $em->flush();

        return $this->respondOK();
    }

    /**
    * @Route("/orders/{id}", methods="PUT")
    */
    public function updatePizzaOrder(Request $request, $id, PizzaOrderRepository $pizzaOrderRepository, CustomerRepository $customerRepository, OrderStatusRepository $orderStatusRepository, EntityManagerInterface $em)
    {
        $request = $this->transformJsonBody($request);

        if (! $request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        $pizzaOrder  = $pizzaOrderRepository->find($id);

        if (!$pizzaOrder) {
            return $this->respondNotFound();
        }

        // validate the customer id
        if ($request->get('customer_id')) {
            $customer  = $customerRepository->find($request->get('customer_id'));

            if (!$customer) {
                return $this->respondValidationError('Please provide a valid Customer ID');
            }

            $pizzaOrder->setCustomerID($request->get('customer_id'));
        }

        // validate the order status id
        if ($request->get('order_status_id')) {
            $orderStatus  = $orderStatusRepository->find($request->get('order_status_id'));

            if (!$orderStatus) {
                return $this->respondValidationError('Please provide a valid Order Status ID');
            }

            $pizzaOrder->setOrderStatusId($request->get('order_status_id'));
        }

        // validate the total price
        if($request->get('total_price') && ($request->get('total_price_dollar') || $request->get('total_price_cent'))){
            return $this->respondValidationError('Please either Total Price or Total Price Dollar with Total Price Cents!');
        } else if($request->get('total_price')) {
            $totalPriceArray = explode(".",$request->get('total_price'));
            try{
                $totalPriceDollar = intval($totalPriceArray[0]);
            } catch (\Exception $e){
                return $this->respondValidationError('Failed to Parse Dollars from Total Price!');
            }

            try{
                $totalPriceCent = intval($totalPriceArray[1]);
            } catch (\Exception $e){
                return $this->respondValidationError('Failed to Parse Cents from Total Price!');
            }  

            $pizzaOrder->setTotalPriceDollar($totalPriceDollar);
            $pizzaOrder->setTotalPriceCent($totalPriceCent);
        } else {          
            // validate the total price dollar ammount
            if ($request->get('total_price_dollar')) {
                $pizzaOrder->setTotalPriceDollar($request->get('total_price_dollar'));
            }

            // validate the total price dollar ammount
            if ($request->get('total_price_cent')) {
                $pizzaOrder->setTotalPriceCent($request->get('total_price_cent'));
            }
        }

        $em->persist($pizzaOrder);
        $em->flush();

        return $this->respondCreated($pizzaOrderRepository->transform($pizzaOrder));
    }

    /**
    * @Route("/orders/{id}", methods="DELETE")
    */
    public function deletePizzaOrder($id, PizzaOrderRepository $pizzaOrderRepository, EntityManagerInterface $em)
    {
        $pizzaOrder  = $pizzaOrderRepository->find($id);

        if (!$pizzaOrder) {
            return $this->respondNotFound();
        }

        $em->remove($pizzaOrder);
        $em->flush();

        return $this->respondOK();
    }

    /**************************************************************************
    * End Order                                                               *
    **************************************************************************/

    /**************************************************************************
    * Begin Order Status                                                      *
    **************************************************************************/

    /**
    * @Route("/orders/status", methods="GET")
    */
    public function getOrderStatus(OrderStatusRepository $orderStatusRepository, EntityManagerInterface $em)
    {
        $orderStatus = $orderStatusRepository->transformAll();

        return $this->respond($orderStatus);
    }
    
    /**
    * @Route("/orders/status/{id}", methods="GET")
    */
    public function getOrderStatusDescription($id, OrderStatusRepository $orderStatusRepository, EntityManagerInterface $em)
    {
        $orderStatus  = $orderStatusRepository->find($id);

        if (!$orderStatus) {
            return $this->respondNotFound();
        }

        $em->persist($orderStatus);
        $em->flush();

        return $this->respondCreated($orderStatusRepository->transform($orderStatus));
    }

    /**************************************************************************
    * End Order Status                                                        *
    **************************************************************************/

    /**************************************************************************
    * Begin OrderLine                                                         *
    **************************************************************************/

     /**
    * @Route("/orders/orderlines", methods="GET")
    */
    public function getPizzaOrderLines(PizzaOrderLineRepository $pizzaOrderLineRepository)
    {
        $pizzaOrderLines = $pizzaOrderLineRepository->transformAll();

        return $this->respond($pizzaOrderLines);
    }

    /**
    * @Route("/orders/orderslines/{id}", methods="GET")
    */
    public function getPizzaOrderLine($id, PizzaOrderLineRepository $pizzaOrderLineRepository, EntityManagerInterface $em)
    {
        $pizzaOrderLine  = $pizzaOrderLineRepository->find($id);

        if (!$pizzaOrderLine) {
            return $this->respondNotFound();
        }

        $em->persist($pizzaOrderLine);
        $em->flush();

        return $this->respondCreated($pizzaOrderLineRepository->transform($pizzaOrderLine));
    }

    /**
    * @Route("/orders/orderlines", methods="POST")
    */
    public function createPizzaOrderLine(Request $request, PizzaOrderRepository $pizzaOrderRepository, PizzaSizeRepository $pizzaSizeRepository, PizzaCombinationRepository $pizzaCombinationRepository, EntityManagerInterface $em)
    {
        $totalPriceDollar = 0;
        $totalPriceCent = 0;
        $priceDollar = 0;
        $priceCent = 0;

        $request = $this->transformJsonBody($request);

        if (! $request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        // validate the order id
        if (! $request->get('order_id')) {
            return $this->respondValidationError('Please provide a Order ID!');
        }

        $pizzaOrder  = $pizzaOrderRepository->find($request->get('order_id'));

        if (!$pizzaOrder) {
            return $this->respondValidationError('Please provide a valid Order ID');
        }

        // validate the pizza size id
        if (! $request->get('pizza_size_id')) {
            return $this->respondValidationError('Please provide a Pizza Size ID!');
        }
        
        $pizzaSize  = $pizzaSizeRepository->find($request->get('pizza_size_id'));
        
        if (!$pizzaSize) {
            return $this->respondValidationError('Please provide a valid Pizza Size ID');
        }

        // validate the pizza combination id
        if (! $request->get('pizza_combination_id')) {
            return $this->respondValidationError('Please provide a Pizza Combination ID!');
        }
                
        $pizzaCombinations  = $pizzaCombinationRepository->findAll($request->get('pizza_combination_id'));
                
        if (!$pizzaCombinations) {
            return $this->respondValidationError('Please provide a valid Pizza Combination ID');
        }

        foreach($pizzaCombinations as $pizzaCombination){
            $priceDollar += $pizzaCombination->getPriceDollar();
            $priceCent += $pizzaCombination->getPriceCent();

            if($priceCent > 99){
                $dollarsFromCent = floor($priceCent / 100);
                $priceDollar += $dollarsFromCent; 
                $priceCent = $priceCent % 100;
            }
        }

        $totalPriceDollar = $pizzaOrder->getTotalPriceDollar();
        $totalPriceCent = $pizzaOrder->getTotalPriceCent();

        $totalPriceDollar += $priceDollar; 
        $totalPriceCent += $priceCent;

        if($priceCent > 99){
            $totalDollarsFromCent = floor($totalPriceCent / 100);
            $totalPriceDollar += $totalDollarsFromCent; 
            $totalPriceCent = $totalPriceCent % 100;
        }

        $pizzaOrderLine = new PizzaOrderLine;
        $pizzaOrderLine->setPizzaOrderId($request->get('order_id'));
        $pizzaOrderLine->setPizzaCombinationId($request->get('pizza_combination_id'));
        $pizzaOrderLine->setPizzaSizeId($request->get('pizza_size_id'));
        $pizzaOrderLine->setPriceDollar($priceDollar);
        $pizzaOrderLine->setPriceCent($priceCent);
        $em->persist($pizzaOrderLine);

        $pizzaOrder->setTotalPriceDollar($totalPriceDollar);
        $pizzaOrder->setTotalPriceDollar($totalPriceCent);
        $em->persist($pizzaOrder);
        $em->flush();

        return $this->respondOK();
    }

    /**
    * @Route("/orders/orderlines/{id}", methods="PUT")
    */
    public function updatePizzaOrderLine(Request $request, $id, PizzaOrderLineRepository $pizzaOrderLineRepository, PizzaOrderRepository $pizzaOrderRepository, PizzaSizeRepository $pizzaSizeRepository, PizzaCombinationRepository $pizzaCombinationRepository, EntityManagerInterface $em)
    {
        $request = $this->transformJsonBody($request);

        if (! $request) {
            return $this->respondValidationError('Please provide a valid request!');
        }

        $pizzaOrderLine  = $pizzaOrderLineRepository->find($id);

        if (!$pizzaOrderLine) {
            return $this->respondNotFound();
        }

        // validate the order id
        if ($request->get('order_id')) {
            $pizzaOrder  = $pizzaOrderRepository->find($request->get('order_id'));

            if (!$pizzaOrder) {
                return $this->respondValidationError('Please provide a valid Order ID');
            }

            $pizzaOrderLine->setPizzaOrderId($request->get('order_id'));
        }

        // validate the pizza size id
        if (! $request->get('pizza_size_id')) {
            $pizzaSize  = $pizzaSizeRepository->find($request->get('pizza_size_id'));

            if (!$pizzaSize) {
                return $this->respondValidationError('Please provide a valid Pizza Size ID');
            }

            $pizzaOrderLine->setPizzaSizeId($request->get('pizza_size_id'));
        }
        

        // validate the pizza combination id
        if (! $request->get('pizza_combination_id')) {
            $pizzaCombinations  = $pizzaCombinationRepository->find($request->get('pizza_combination_id'));
            
            if (!$pizzaCombinations) {
                return $this->respondValidationError('Please provide a valid Pizza Combination ID');
            }

            $pizzaOrderLine->setPizzaCombinationId($request->get('pizza_combination_id'));
        }
                
        // validate the total price
        if($request->get('price') && ($request->get('price_dollar') || $request->get('price_cent'))){
            return $this->respondValidationError('Please either Price or Price Dollar with Price Cents!');
        } else if($request->get('price')) {
            $priceArray = explode(".",$request->get('price'));
            try{
                $priceDollar = intval($priceArray[0]);
            } catch (\Exception $e){
                return $this->respondValidationError('Failed to Parse Dollars from Total Price!');
            }

            try{
                $priceCent = intval($priceArray[1]);
            } catch (\Exception $e){
                return $this->respondValidationError('Failed to Parse Cents from Total Price!');
            }  

            $pizzaOrderLine->setPriceDollar($priceDollar);
            $pizzaOrderLine->setPriceCent($priceCent);
        } else {          
            // validate the total price dollar ammount
            if ($request->get('price_dollar')) {
                $pizzaOrder->setTotalPriceDollar($request->get('price_dollar'));
            }

            // validate the total price dollar ammount
            if ($request->get('price_cent')) {
                $pizzaOrder->setTotalPriceCent($request->get('price_cent'));
            }
        }

        $em->persist($pizzaOrder);
        $em->flush();

        return $this->respondCreated($pizzaOrderRepository->transform($pizzaOrder));
    }

    /**
    * @Route("/orders/orderlines/{id}", methods="DELETE")
    */
    public function deletePizzaOrderLine($id, PizzaOrderLineRepository $pizzaOrderLineRepository, EntityManagerInterface $em)
    {
        $pizzaOrderLine  = $pizzaOrderLineRepository->find($id);

        if (!$pizzaOrderLine) {
            return $this->respondNotFound();
        }

        $em->remove($pizzaOrderLine);
        $em->flush();

        return $this->respondOK();
    }

    /**************************************************************************
    * End OrderLine                                                           *
    **************************************************************************/
}
?>
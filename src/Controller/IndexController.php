<?php

namespace App\Controller;

use App\Entity\Airports;
use App\Entity\Routes;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class IndexController extends AbstractController
{
    /**
     * @Route("/", name="helloWorld", methods="GET")
     */
    public function index(): JsonResponse
    {
        
        return new JsonResponse(['success' => true, 'data' => 'Hello World']);
    }

    /**
     * @Route("/best-route", name="GetRoute", methods="GET")
     * @param ManagerRegistry $doctrine
     */
    public function bestRoute(): JsonResponse
    {
        try{

            $from = isset($_GET['from']) ? (int)$_GET['from'] : 0;
            $to = isset($_GET['to']) ? (int)$_GET['to'] : 0;

            if($from == 0){
                return new JsonResponse(['success' => false, 'data' => null, 'message' => 'Invalid parameter From ID']);
            }

            if($to == 0){
                return new JsonResponse(['success' => false, 'data' => null, 'message' => 'Invalid parameter To ID']);
            }


            $conn = $this->getDoctrine()->getManager()
                ->getConnection();
            
            $maxSql = "SET max_recursive_iterations = 2;";
            $stmt = $conn->prepare($maxSql);
            $stmt->execute();

            $sql = "
                    with RECURSIVE cte2 as(
                        SELECT origin, destiny, 0 as stops, CONVERT( (Concat(origin , '-' ,  destiny) ), char(255)) as exact_route
                        FROM `Routes`
                    UNION ALL
                        SELECT f.origin, cte2.destiny, 1 + cte2.stops, CONVERT( (CONCAT(f.origin , '-'  , cte2.exact_route)), char(255))
                        FROM Routes f inner join
                        cte2 on f.destiny = cte2.origin
                                    
                    )
                    select  o.airportName as origin_airport,o.cityName origin_city,o.countryName origin_country,
                            d.airportName as destination_airport,d.cityName destination_city,d.countryName destination_country,cte2.stops, cte2.exact_route
                    from cte2 
                            INNER JOIN (Select A.id,A.airportName,city.cityName,C.countryName from Airports A 
                                INNER JOIN Countries C ON A.countryId = C.id
                                INNER JOIN Cities city ON A.cityId = city.id) o ON cte2.origin = o.airportName
                            INNER JOIN (Select A.id,A.airportName,city.cityName,C.countryName from Airports A 
                                INNER JOIN Countries C ON A.countryId = C.id
                                INNER JOIN Cities city ON A.cityId = city.id) d ON cte2.destiny = d.airportName
                    Where o.id = $from and d.id = $to
                    order by stops
                    limit 1";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();

            
            return new JsonResponse(['success' => true, 'data' => $data]);

        }catch(\Exception $e){
            return new JsonResponse(['success' => false, 'data' => null, 'message' => 'Something went wrong.']);
        }
        

    }
}

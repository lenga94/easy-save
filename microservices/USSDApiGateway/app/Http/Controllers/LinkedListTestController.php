<?php

namespace App\Http\Controllers;

use App\Config\UssdConfig;
use App\Entities\LevelNode;
use App\Entities\LinkedList;
use App\Entities\USSDHandler;
use App\Menus\EasySaveMenu;
use App\Product;
use App\Traits\ApiResponser;
use App\UssdSession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Http\ResponseFactory;

class LinkedListTestController extends Controller
{
    use ApiResponser;

    public function testLinkedList()
    {
        $product = Product::find(1);

        echo "\n\n Display product types \n\n";
        echo json_encode($product->productTypes);
        echo "\n\n";



//        $linkedList = new LinkedList();
//
//        $linkedList->insertFirst('first node');
//
//        echo "\n\n Linked list after adding first node \n\n";
//        echo json_encode($linkedList);
//        echo "\n\n";
//
//        $linkedList->insertLast('second node');
//
//        echo "\n\n Linked list after adding second node \n\n";
//        echo json_encode($linkedList);
//        echo "\n\n";
//
//        $linkedList->insertLast('third node');
//
//        echo "\n\n Linked list after adding third node \n\n";
//        echo json_encode($linkedList);
//        echo "\n\n";
//
//        $linkedList->insertLast('fourth node');
//
//        echo "\n\n Linked list after adding fourth node \n\n";
//        echo json_encode($linkedList);
//        echo "\n\n";
//
//        $linkedList->insertLast('fifth node');
//
//        echo "\n\n Linked list after adding fifth node \n\n";
//        echo json_encode($linkedList);
//        echo "\n\n";
//
//        echo "\n\n Get node at first position \n\n";
//        echo json_encode($linkedList->getNthElement(5));
//        echo "\n\n";
//
//        echo "\n\n Get node at last position \n\n";
//        echo json_encode($linkedList->getNthElement($linkedList->getCount()));
//        echo "\n\n";
//
//        echo "\n\n Get node at second last position \n\n";
//        echo json_encode($linkedList->getNthElement($linkedList->getCount() - 1));
//        echo "\n\n";
//
//        echo "\n\n Get node at third last position \n\n";
//        echo json_encode($linkedList->getNthElement($linkedList->getCount() - 2));
//        echo "\n\n";
//
//
//        echo "\n\n Get node at zero position from last \n\n";
//        echo json_encode($linkedList->getNthElementFromLast());
//        echo "\n\n";
    }
}



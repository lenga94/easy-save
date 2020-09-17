<?php

namespace App\Http\Controllers;

use App\Client;
use App\HouseOwnersProductRate;
use App\ProductType;
use App\RegisteredClient;
use App\Services\ApiGatewayService;
use App\Traits\ResponseHandler;
use Exception;
use App\Config\UssdConfig;
use App\Entities\DateDetails;
use App\Entities\MotorInsuranceQuarterListComputations;
use App\Entities\MotorThirdPartyComputeForm;
use App\Entities\Transaction;
use App\Entities\USSDHandler;
use App\Menus\EasySaveMenu;
use App\MTPProductRate;
use App\Traits\ApiResponser;
use App\UssdSession;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Http\ResponseFactory;
use Faker\Factory;

class USSDController extends Controller
{
    use ApiResponser;
    use ResponseHandler;

    /**
     * The menu object holding all necessary menus list to display.
     * @var EasySaveMenu
     */
    public $easySaveMenu;

    /**
     * The service to consume the web app api gateway service.
     * @var ApiGatewayService
     */
    public $apiGateway;


    /**
     * Create a new controller instance.
     * @param EasySaveMenu $easySaveMenu
     * @param ApiGatewayService $apiGateway
     */
    public function __construct(EasySaveMenu $easySaveMenu, ApiGatewayService $apiGateway)
    {
        $this->easySaveMenu = $easySaveMenu;
        $this->apiGateway = $apiGateway;
    }


    /**
     * Inception function of USSD application
     * @param Request $request
     * @return Response|ResponseFactory
     * @throws ValidationException
     */
    public function index(Request $request)
    {
        $rules = [
            'input' => 'required|max:50',
            'sessionID' => 'required|max:50',
            'msisdn' => 'required|max:12',
            'isnewrequest' => 'required|numeric|min:0',
        ];

        //validate request
        $this->validate($request, $rules);

        //manage request and retrieve ussd handler
        $ussdHandler = $this->manageRequest($request);

        if(env('APP_ENV') === 'local') {

            echo "\n\n USSD Handler After Manage Request Stage \n\n";
            echo json_encode($ussdHandler);
            echo "\n\n";
        }

        //formulate MNO response
        $this->formulateMNOResponse($ussdHandler);

        //send success response
        return $this->successResponse($ussdHandler->getResponseBody(), Response::HTTP_OK, 2);
    }


    /**
     * Create a new controller instance.
     * @param Request $request
     * @return USSDHandler|mixed
     */
    private function manageRequest(Request $request) {

        //get request values
        $input = trim($request->input); //get input
        $sessionId = $request->sessionID; //get sessionId
        $msisdn = $request->msisdn; //get msisdn
        $isnewrequest = $request->isnewrequest; //get is new request

        //create new USSD handler object
        $ussdHandler = new USSDHandler($input, $sessionId, $msisdn, $isnewrequest);

        if ($ussdSession = $this->isSessionExisting($ussdHandler)) {

            $existingUssdHandler = unserialize($ussdSession->payload);

            //set session history from existing ussd handler in session as session history of newly created ussd handler
            $ussdHandler->setSessionHistory($existingUssdHandler->getSessionHistory());

            //set session variables array from existing ussd handler in session as session variables array of newly created ussd handler
            $ussdHandler->setSessionVariables($existingUssdHandler->getSessionVariables());

            //save updated ussd handler session variable values in database
            $this->updateRequestSession($ussdHandler);

            //process function to run
            $this->processFunctionToRun($ussdHandler);
        } else {

            //create new node and set it as first node
            $ussdHandler->getSessionHistory()->insertFirst("init");

            //store and return request session
            $this->storeRequestSession($ussdHandler);

            //process function to run
            $this->processFunctionToRun($ussdHandler);
        }

        return $ussdHandler;
    }





    private function isSessionExisting(USSDHandler $ussdHandler) {

        //find session in database
        return $ussdSession = UssdSession::where([
            ['session_id', $ussdHandler->getSessionId()],
            ['phone_number', $ussdHandler->getMsisdn()],
        ])->first();
    }

    private function storeRequestSession(USSDHandler $ussdHandler)
    {
        //store session in database
        return UssdSession::create([
            'session_id' => $ussdHandler->getSessionId(),
            'phone_number' => $ussdHandler->getMsisdn(),
            'payload' => serialize($ussdHandler),
        ]);
    }

    private function updateRequestSession(USSDHandler $ussdHandler)
    {
        if($ussdSession = $this->isSessionExisting($ussdHandler)) {

            //update payload
            $ussdSession->fill(['payload' => serialize($ussdHandler)]);
            $ussdSession->save();

            return $ussdSession;
        }

        return null;

    }

    private function destroyUSSDSession(USSDHandler $ussdHandler) {

        //set 'is session continuing variable to false'
        $ussdHandler->setIsSessionContinuing(false);

        //save updated ussd handler session variable values in database
        $this->updateRequestSession($ussdHandler);
    }

    private function completeProcessingRequest(USSDHandler $ussdHandler, $text, $functionToCall, $isSessionContinuing = true) {

        //set ussd handler 'response body' variable
        $ussdHandler->setResponseBody($text);

        //set ussd handler 'is session continuing' variable
        $ussdHandler->setIsSessionContinuing($isSessionContinuing);

        if($functionToCall != null) {
            //add new node at the end of the linked list
            $ussdHandler->getSessionHistory()->insertLast($functionToCall);
        }

        //save updated ussd handler session variable values in database
        $this->updateRequestSession($ussdHandler);

        if (!$isSessionContinuing) {
            $this->destroyUSSDSession($ussdHandler);
        }
    }

    private function formulateMNOResponse(USSDHandler $ussdHandler)
    {
        //headers
        $sessionId = $ussdHandler->getSessionId();
        $freeFlow = ($ussdHandler->getIsSessionContinuing()) ? "FC" : "FB";
        $msisdn =  $ussdHandler->getMsisdn();

        header("sessionId: {$sessionId}");
        header("Freeflow: {$freeFlow}");
        header("MSISDN: {$msisdn}");
    }

    private function processFunctionToRun(USSDHandler $ussdHandler)
    {
        $functionToRun = null;

        if($ussdHandler->getInput() == UssdConfig::BACK_MENU_OPTION_CHARACTER) {

        } else if($ussdHandler->getInput() == UssdConfig::MAIN_MENU_OPTION_CHARACTER) {

        } else if($ussdHandler->getInput() == UssdConfig::EXIT_MENU_OPTION_CHARACTER) {

        } else {
            $functionToRun = $ussdHandler->getSessionHistory()->getNthElementFromLast()->getData();
        }

        switch ($functionToRun) {
            case "init":
                $this->init($ussdHandler);
                break;
            case "processRegistrationRequestMenu":
                $this->processRegistrationRequestMenu($ussdHandler);
                break;
            case "processConfirmRegistrationMenu":
                $this->processConfirmRegistrationMenu($ussdHandler);
                break;
            case "processEasySaveMainMenu":
                $this->processEasySaveMainMenu($ussdHandler);
                break;
            case "processVehicleRegistrationNumberRequest":
                $this->processVehicleRegistrationNumberRequest($ussdHandler);
                break;
            case "processVehicleMakeAndModelRequest":
                $this->processVehicleMakeAndModelRequest($ussdHandler);
                break;
            case "processCoverStartDateRequest":
                $this->processCoverStartDateRequest($ussdHandler);
                break;
            case "processSelectNumberOfQuartersMenu":
                $this->processSelectNumberOfQuartersMenu($ussdHandler);
                break;
            case "processConfirmPolicyPurchaseMenu":
                $this->processConfirmPolicyPurchaseMenu($ussdHandler);
                break;
            case "processSelectNumberOfMonthsMenu":
                $this->processSelectNumberOfMonthsMenu($ussdHandler);
                break;
            case "processRequestBeneficiaryFullNamesMenu":
                $this->processRequestBeneficiaryFullNamesMenu($ussdHandler);
                break;
            case "processRequestBeneficiaryRelationshipMenu":
                $this->processRequestBeneficiaryRelationshipMenu($ussdHandler);
                break;
            case "processRequestBeneficiaryContactMenu":
                $this->processRequestBeneficiaryContactMenu($ussdHandler);
                break;
            case "processMobileMoneyPinMenu":
                $this->processMobileMoneyPinMenu($ussdHandler);
                break;
            case "processHouseUsageRequest":
                $this->processHouseUsageRequest($ussdHandler);
                break;
            case "processHouseRoofingRequest":
                $this->processHouseRoofingRequest($ussdHandler);
                break;
            case "processHouseValueRequest":
                $this->processHouseValueRequest($ussdHandler);
                break;

        }
    }


    /********************* **************************************** ************************************ *******************************/
    private function init(USSDHandler $ussdHandler)
    {
        $phoneNumber = $ussdHandler->getMsisdn();

        //step 1: check for client in database
        $client = RegisteredClient::where('phone_number', $phoneNumber)->first();

        if($client) {

            //TODO: display easy save menu

            //load easy save main menu
            $this->completeProcessingRequest(
                $ussdHandler,
                $this->easySaveMenu->easySaveMainMenuPage(),
                "processEasySaveMainMenu"
            );

        } else {

            //TODO: prompt user to register or know more about easy save

            //load registration request menu
            $this->completeProcessingRequest(
                $ussdHandler,
                $this->easySaveMenu->registrationRequestPage(),
                "processRegistrationRequestMenu"
            );
        }
    }

    public function processRegistrationRequestMenu(USSDHandler $ussdHandler){

        $input = $ussdHandler->getInput();

        if($input == UssdConfig::ONE_CHARACTER){

            //load confirm registration request menu
            $this->completeProcessingRequest(
                $ussdHandler,
                $this->easySaveMenu->confirmRegistrationPage(),
                "processConfirmRegistrationMenu"
            );

        } else if($input == UssdConfig::TWO_CHARACTER){

            //load customer care menu page
            $this->completeProcessingRequest(
                $ussdHandler,
                $this->easySaveMenu->easySaveInformationExitPage(),
                null, false
            );
        }
    }

    public function processConfirmRegistrationMenu(USSDHandler $ussdHandler)
    {
        $input = $ussdHandler->getInput();
        $phoneNumber = $ussdHandler->getMsisdn();

        if($input == UssdConfig::ONE_CHARACTER){

            //TODO: get client data from MNO
            $faker = Factory::create();

            $gender = $faker->randomElement(['male', 'female']);
            $firstName = $faker->firstName($gender);
            $lastName = $faker->lastName;
            $nrc = rand(000000, 999999) ."/". rand(10, 12) ."/". 1;
            $residentialAddress = $faker->address;

            $clientData = array(
                'first_name' => $firstName,
                'last_name' => $lastName,
                'nrc' => $nrc,
                'gender' => strtoupper($gender),
                'residential_address' => $residentialAddress,
                'phone_number' => $phoneNumber,
            );

            $ussdHandler->setSessionVariable('client', $clientData);

            //TODO: post client data to client service through API gateway
            $response = $this->getResponse($this->apiGateway->createClient($clientData));

            if($response->code == Response::HTTP_CREATED) {

                //create new client in database
                RegisteredClient::create($clientData);

                //load customer care menu page
                $this->completeProcessingRequest(
                    $ussdHandler,
                    $this->easySaveMenu->easySaveRegistrationThankYouPage(),
                    null, false
                );

            } else {

                //load customer care menu page
                $this->completeProcessingRequest(
                    $ussdHandler,
                    $this->easySaveMenu->easySaveRegistrationErrorPage(),
                    null, false
                );
            }



        } else if($input == UssdConfig::TWO_CHARACTER) {


            //load registration request menu
            $this->completeProcessingRequest(
                $ussdHandler,
                $this->easySaveMenu->registrationRequestPage(),
                "processRegistrationRequestMenu"
            );
        }
    }

    public function processEasySaveMainMenu(USSDHandler $ussdHandler)
    {
        //get input
        $input = $ussdHandler->getInput();

        if($input == UssdConfig::ONE_CHARACTER) {

            //TODO: send re
        } else if($input == UssdConfig::TWO_CHARACTER) {

        } else if($input == UssdConfig::THREE_CHARACTER) {

        } else if($input == UssdConfig::FOUR_CHARACTER) {

        }


        //get selected product from session variables array
        $selectedProduct = $ussdHandler->getSessionVariable('selected_product');

        //get transaction from session variables array
        $transaction = $ussdHandler->getSessionVariable('transaction');

        //get mtp cover types array from session variables array
        $productTypes = $ussdHandler->getSessionVariable('mtp_cover_types');

        //get count of product types array
        $productTypesCount = count($productTypes);

        //validate input using available products count
        if($input <= 0 || $input > $productTypesCount) {
            //TODO: respond with invalid input message
        } else {
            //get selected product type using input
            $selectedProductType = $productTypes[$input - 1];

            //set transaction cover type
            $transaction->setCoverType($selectedProductType);

            //load 'request vehicle registration number menu'
            $this->completeProcessingRequest(
                $ussdHandler,
                $this->easySaveMenu->requestVehicleRegistrationNumberPage(),
                "processVehicleRegistrationNumberRequest"
            );
        }
    }

    public function processVehicleRegistrationNumberRequest(USSDHandler $ussdHandler)
    {
        //get input
        $vehicleRegistrationNumber = $ussdHandler->getInput();

        //get transaction from session variables array
        $transaction = $ussdHandler->getSessionVariable('transaction');

        //add vehicle registration number to risk details array
        $transaction->setRiskDetail('registration_number', $vehicleRegistrationNumber);

        //load 'request vehicle make and vehicle model'
        $this->completeProcessingRequest(
            $ussdHandler,
            $this->easySaveMenu->requestVehicleMakeAndModelPage(),
            "processVehicleMakeAndModelRequest"
        );
    }

    public function processVehicleMakeAndModelRequest(USSDHandler $ussdHandler)
    {
        //get input
        $vehicleMakeAndModel = $ussdHandler->getInput();
        $vehicleMakeAndModelArray = explode("-", $vehicleMakeAndModel);

        //validate input
        if(count($vehicleMakeAndModelArray) != 2) {
            //TODO: send invalid input message
        } else {
            $vehicleMake = $vehicleMakeAndModelArray[0];
            $vehicleModel = $vehicleMakeAndModelArray[1];

            //get transaction from session variables array
            $transaction = $ussdHandler->getSessionVariable('transaction');

            //add vehicle make to risk details array
            $transaction->setRiskDetail('vehicle_make', $vehicleMake);

            //add vehicle model to risk details array
            $transaction->setRiskDetail('vehicle_model', $vehicleModel);

            //load 'request cover start date'
            $this->completeProcessingRequest(
                $ussdHandler,
                $this->easySaveMenu->requestCoverStartDatePage(),
                "processCoverStartDateRequest"
            );
        }
    }

    public function processCoverStartDateRequest(USSDHandler $ussdHandler)
    {
        $date = $ussdHandler->getInput();

        $dateArray = explode("-", $date);

        //validate input
        if(count($dateArray) != 3) {
            //TODO: invalid input, send error message
        } else {

            $month = $dateArray[1]; //get month
            $day = $dateArray[0]; //get day
            $year = $dateArray[2]; //get year

            //validate date
            if(checkdate($month, $day, $year)) {

                //create cover start date as carbon object
                $coverStartDate = Carbon::createFromFormat('d-m-Y', $date);

                //get transaction from session variables array
                $transaction = $ussdHandler->getSessionVariable('transaction');

                //set cover start date transaction attribute
                $transaction->setCoverStartDate($coverStartDate);

                $productType = $transaction->getProductType();

                if($productType == "Motor Third Party") {
                    //fetch quarter premium prices and compute quarter end dates
                    $response = $this->getMotorThirdPartyComputationList($transaction);

                    if($response['status']) {
                        $computations = $response['computations'];

                        //add quarters list as session variable
                        $ussdHandler->setSessionVariable("quarters_list", $computations);

                        //load quarters and quarter prices option menu
                        $this->completeProcessingRequest(
                            $ussdHandler,
                            $this->easySaveMenu->selectNumberOfQuartersPage($computations),
                            "processSelectNumberOfQuartersMenu"
                        );
                    }

                } else if($productType == "Local Travel/Mwende Bwino") {

                        //load select number of months menu
                        $this->completeProcessingRequest(
                            $ussdHandler,
                            $this->easySaveMenu->selectNumberOfMonthsPage(),
                            "processSelectNumberOfMonthsMenu"
                        );
                } else if($productType == "House Owners") {

                    $coverPeriod = 1;

                    //add cover period to cover start date
                    $coverEndDate = $coverStartDate->copy();
                    $coverEndDate->addYears($coverPeriod)->subDay();


                    //set cover end date
                    $transaction->setCoverEndDate($coverEndDate);

                    //set cover period
                    $transaction->setCoverPeriod($coverPeriod);

                    //set cover period type
                    $transaction->setCoverPeriodType("year");

                    //load request house value
                    $this->completeProcessingRequest(
                        $ussdHandler,
                        $this->easySaveMenu->requestHouseValuePage(),
                        "processHouseValueRequest"
                    );

                }

            } else {
                //TODO: invalid date, send error message
            }
        }
    }

    public function processSelectNumberOfQuartersMenu(USSDHandler $ussdHandler)
    {
        $numberOfQuarters = $ussdHandler->getInput();

        //get quarters list from session variables array
        $quartersList = $ussdHandler->getSessionVariable('quarters_list');

        //get transaction from session variables array
        $transaction = $ussdHandler->getSessionVariable('transaction');

        //get count of quarters list array
        $quartersListCount = count($quartersList);

        //validate input using available products count
        if($numberOfQuarters <= 0 || $numberOfQuarters > $quartersListCount) {
            //TODO: respond with invalid input message
        } else {
            //get selected quarter using input
            $selectedQuarter = $quartersList[$numberOfQuarters - 1];

            //set selected quarter as session variable
            $ussdHandler->setSessionVariable("selected_quarter", $selectedQuarter);

            //set transaction end date
            $transaction->setCoverEndDate(Carbon::createFromFormat('Y-m-d', $selectedQuarter->getEndDate()));

            //set premium
            $transaction->setPremium($selectedQuarter->getPremium());

            //set cover period
            $transaction->setCoverPeriod($selectedQuarter->getNumberOfQuarters());

            //set cover period type
            $transaction->setCoverPeriodType("quarter");

            //load confirm motor third party purchase page
            $this->completeProcessingRequest(
                $ussdHandler,
                $this->easySaveMenu->confirmPolicyPurchasePage($transaction),
                "processConfirmPolicyPurchaseMenu"
            );
        }
    }

    public function processConfirmPolicyPurchaseMenu(USSDHandler $ussdHandler)
    {
        //get input
        $input = $ussdHandler->getInput();

        //get transaction from session variables array
        $transaction = $ussdHandler->getSessionVariable('transaction');

        //get product type
        $productType = $transaction->getProductType();

        if($input == UssdConfig::ONE_CHARACTER) {

            if($productType == 'Motor Third Party' ) {

                //load request mobile money page
                $this->completeProcessingRequest(
                    $ussdHandler,
                    $this->easySaveMenu->requestMobileMoneyPinPage(),
                    "processMobileMoneyPinMenu"
                );

            } else if($productType == "Local Travel/Mwende Bwino") {

                //load request beneficiary full names page
                $this->completeProcessingRequest(
                    $ussdHandler,
                    $this->easySaveMenu->requestBeneficiaryFullNamesPage(),
                    "processRequestBeneficiaryFullNamesMenu"
                );

            } else if($productType == 'House Owners') {

                //load request mobile money page
                $this->completeProcessingRequest(
                    $ussdHandler,
                    $this->easySaveMenu->requestMobileMoneyPinPage(),
                    "processMobileMoneyPinMenu"
                );
            }


        } else if($ussdHandler->getInput() == UssdConfig::TWO_CHARACTER) {

            //send quotation information to backbone API
            //that will send sms to client and notify staff

            //load exit page menu page
            $this->completeProcessingRequest(
                $ussdHandler,
                $this->easySaveMenu->quotationRequestThankYouPage(),
                null, false
            );

            //send customer care information to ERP

        } else if($ussdHandler->getInput() == UssdConfig::THREE_CHARACTER) {

            //load exit page menu page
            $this->completeProcessingRequest(
                $ussdHandler,
                $this->easySaveMenu->exitPage(),
                null, false
            );

        } else {

            $prefix = "Invalid input!";

            if($ussdHandler->getInput() == UssdConfig::MAIN_MENU_OPTION_CHARACTER ||
                $ussdHandler->getInput() == UssdConfig::BACK_MENU_OPTION_CHARACTER) {
                $prefix = null;
            }

            //get transaction from session variables array
            $transaction = $ussdHandler->getSessionVariable('transaction');

            //load confirm MTP purchase menu
            $this->completeProcessingRequest(
                $ussdHandler,
                $this->easySaveMenu->confirmPolicyPurchasePage($transaction, $prefix),
                null
            );
        }
    }

    public function processSelectNumberOfMonthsMenu(USSDHandler $ussdHandler)
    {
        $numberOfMonths = $ussdHandler->getInput();

        if($numberOfMonths <= 0 || $numberOfMonths > 5) {
            //TODO: return invalid input
        } else {

            //get transaction from session variables array
            $transaction = $ussdHandler->getSessionVariable('transaction');

            $coverPeriod = 0;
            $premium = 0;

            if($numberOfMonths == UssdConfig::ONE_CHARACTER) {
                $coverPeriod = 1;
                $premium = 5;
            } else if($numberOfMonths == UssdConfig::TWO_CHARACTER) {
                $coverPeriod = 3;
                $premium = 15;
            } else if($numberOfMonths == UssdConfig::THREE_CHARACTER) {
                $coverPeriod = 6;
                $premium = 30;
            } else if($numberOfMonths == UssdConfig::FOUR_CHARACTER) {
                $coverPeriod = 9;
                $premium = 45;
            } else if($numberOfMonths == UssdConfig::FIVE_CHARACTER) {
                $coverPeriod = 12;
                $premium = 60;
            }

            //set premium
            $transaction->setPremium($premium);

            //get cover start date
            $coverStartDate = $transaction->getCoverStartDate();

            //add cover period to cover start date
            $coverEndDate = $coverStartDate->copy();
            $coverEndDate->addMonths($coverPeriod);

            //set cover end date
            $transaction->setCoverEndDate($coverEndDate);

            //set cover period
            $transaction->setCoverPeriod($coverPeriod);

            //set cover period type
            $transaction->setCoverPeriodType("month");

            //load confirm muende bwino purchase page
            $this->completeProcessingRequest(
                $ussdHandler,
                $this->easySaveMenu->confirmPolicyPurchasePage($transaction),
                "processConfirmPolicyPurchaseMenu"
            );
        }
    }

    public function processRequestBeneficiaryFullNamesMenu(USSDHandler $ussdHandler)
    {
        $beneficiaryFullNames = $ussdHandler->getInput();

        //get transaction from session variables array
        $transaction = $ussdHandler->getSessionVariable('transaction');

        //add beneficiary full names to risk details array
        $transaction->setRiskDetail('beneficiary_full_names', $beneficiaryFullNames);

        //load request beneficiary relationship page
        $this->completeProcessingRequest(
            $ussdHandler,
            $this->easySaveMenu->requestBeneficiaryRelationshipPage($beneficiaryFullNames),
            "processRequestBeneficiaryRelationshipMenu"
        );

    }

    public function processRequestBeneficiaryRelationshipMenu(USSDHandler $ussdHandler)
    {
        $beneficiaryRelationship = $ussdHandler->getInput();

        //get transaction from session variables array
        $transaction = $ussdHandler->getSessionVariable('transaction');

        //add beneficiary relationship to risk details array
        $transaction->setRiskDetail('beneficiary_relationship', $beneficiaryRelationship);

        //get beneficiary name from risk details array
        $beneficiaryFullNames = $transaction->getRiskDetail('beneficiary_full_names');

        //load request beneficiary relationship page
        $this->completeProcessingRequest(
            $ussdHandler,
            $this->easySaveMenu->requestBeneficiaryContactPage($beneficiaryFullNames),
            "processRequestBeneficiaryContactMenu"
        );
    }

    public function processRequestBeneficiaryContactMenu(USSDHandler $ussdHandler)
    {
        $beneficiaryContact = $ussdHandler->getInput();

        //get transaction from session variables array
        $transaction = $ussdHandler->getSessionVariable('transaction');

        //add beneficiary contact to risk details array
        $transaction->setRiskDetail('beneficiary_contact', $beneficiaryContact);

        //load request mobile money page
        $this->completeProcessingRequest(
            $ussdHandler,
            $this->easySaveMenu->requestMobileMoneyPinPage(),
            "processMobileMoneyPinMenu"
        );
    }

    public function processMobileMoneyPinMenu(USSDHandler $ussdHandler)
    {
        $mobileMoneyPin = $ussdHandler->getInput();

        //TODO: process payment using phone number and pin provided

        //TODO: send transaction information to backbone api

        //load thank you menu page
        $this->completeProcessingRequest(
            $ussdHandler,
            $this->easySaveMenu->policyPurchaseErrorPage(),
            null, false
        );
    }

    public function processHouseUsageRequest(USSDHandler $ussdHandler)
    {
        $houseUsage = $ussdHandler->getInput();

        //get transaction from session variables array
        $transaction = $ussdHandler->getSessionVariable('transaction');

        if($houseUsage == UssdConfig::ONE_CHARACTER) {

            //get cover type from database
            $coverType = ProductType::where('product_type_name', 'Residential')->first();

            //set transaction cover type
            $transaction->setCoverType($coverType);

            //load request house roofing
            $this->completeProcessingRequest(
                $ussdHandler,
                $this->easySaveMenu->requestHouseRoofingPage(),
                "processHouseRoofingRequest"
            );

        } else if($houseUsage == UssdConfig::TWO_CHARACTER) {

            //get cover type from database
            $coverType = ProductType::where('product_type_name', 'Residential')->first();

            //set transaction cover type
            $transaction->setCoverType($coverType);

            //load request house roofing
            $this->completeProcessingRequest(
                $ussdHandler,
                $this->easySaveMenu->requestHouseRoofingPage(),
                "processHouseRoofingRequest"
            );

        } else {
            //TODO: invalid input
        }
    }

    public function processHouseRoofingRequest(USSDHandler $ussdHandler)
    {
        $houseRoofing = $ussdHandler->getInput();

        //get transaction from session variables array
        $transaction = $ussdHandler->getSessionVariable('transaction');

        //get transaction cover type
        $coverType = $transaction->getCoverType();

        if($houseRoofing == UssdConfig::ONE_CHARACTER) {

            //get cover type from database
            $coverTypeRate = HouseOwnersProductRate::where([
                ['product_type_id', $coverType->id],
                ['roof_type', 'Standard']
            ])->first();

            //get cover type
            $coverTypeRate->productType;

            //set house owners product rate as session variable
            $ussdHandler->setSessionVariable('house_owners_product_rate', $coverTypeRate);

            //load 'request cover start date'
            $this->completeProcessingRequest(
                $ussdHandler,
                $this->easySaveMenu->requestCoverStartDatePage(),
                "processCoverStartDateRequest"
            );

        } else if($houseRoofing == UssdConfig::TWO_CHARACTER) {

            //get cover type from database
            $coverTypeRate = HouseOwnersProductRate::where([
                ['product_type_id', $coverType->id],
                ['roof_type', 'Thatched']
            ])->first();

            //get cover type
            $coverTypeRate->productType;

            //set house owners product rate as session variable
            $ussdHandler->setSessionVariable('house_owners_product_rate', $coverTypeRate);

            //load 'request cover start date'
            $this->completeProcessingRequest(
                $ussdHandler,
                $this->easySaveMenu->requestCoverStartDatePage(),
                "processCoverStartDateRequest"
            );

        } else {
            //TODO: invalid input
        }
    }

    public function processHouseValueRequest(USSDHandler $ussdHandler)
    {
        $houseValue = $ussdHandler->getInput();

        //get transaction from session variables array
        $transaction = $ussdHandler->getSessionVariable('transaction');

        //get house owners product rate session variable
        $houseOwnersProductRate = $ussdHandler->getSessionVariable('house_owners_product_rate');

        //set house value to risk details array
        $transaction->setRiskDetail('sum_insured', $houseValue);

        //get premium
        $premium = $this->calculateHouseOwnersPremium($houseValue, $houseOwnersProductRate->rate);

        //set premium
        $transaction->setPremium($premium);


        if($houseValue < 200000 || $houseValue >= 750000) {

            //load customer care menu page
            $this->completeProcessingRequest(
                $ussdHandler,
                $this->easySaveMenu->customerCarePage("Kindly"),
                null, false
            );

        } else {

            //load confirm house owners purchase page
            $this->completeProcessingRequest(
                $ussdHandler,
                $this->easySaveMenu->confirmPolicyPurchasePage($transaction),
                "processConfirmPolicyPurchaseMenu"
            );

        }

    }





    /******************************************** ********************************** ****************/

    /**
     * @param Transaction $transaction
     * @return JsonResponse|Response|ResponseFactory
     */
    public function getMotorThirdPartyComputationList(Transaction $transaction)
    {
        $productTypeId = $transaction->getCoverType()->id;

        $mtpProductRates = MTPProductRate::where('product_type_id', $productTypeId)->get();

        if (count($mtpProductRates) > 0) {

            //declare variables
            $startDate = $transaction->getCoverStartDate();

            //create an instance of motor third party compute form class
            $form = new MotorThirdPartyComputeForm($startDate, $productTypeId);

            //compute motor third party prices
            return $this->computeMotorThirdPartyPriceRates($form, $mtpProductRates);

        } else {
            return null;
        }
    }

    private function computeMotorThirdPartyPriceRates(MotorThirdPartyComputeForm $motorThirdPartyComputeForm, $motorThirdPartyPriceRates)
    {
        $response = array();

        try {

            //initialise start date as carbon object
            $startDate = $motorThirdPartyComputeForm->getStartDate();


            $quarterList = $this->generateQuarterList($startDate);

            $quarterOnePeriod = $this->calculatePeriod($startDate, $quarterList['quarter_one']->getLastQuarterDate(), 'days');
            $quarterTwoPeriod = $this->calculatePeriod($startDate, $quarterList['quarter_two']->getLastQuarterDate(), 'days');
            $quarterThreePeriod = $this->calculatePeriod($startDate, $quarterList['quarter_three']->getLastQuarterDate(), 'days');
            $quarterFourPeriod = $this->calculatePeriod($startDate, $quarterList['quarter_four']->getLastQuarterDate(), 'days');

            //initialize quarter premiums to 0
            $oneQuarterPremium = 0;
            $twoQuartersPremium = 0;
            $threeQuartersPremium = 0;
            $fourQuartersPremium = 0;

            foreach($motorThirdPartyPriceRates as $priceRate) {
                if($priceRate->num_of_quarters == 1) {
                    $oneQuarterPremium = $priceRate->price;
                } else if($priceRate->num_of_quarters == 2) {
                    $twoQuartersPremium = $priceRate->price;
                } else if($priceRate->num_of_quarters == 3) {
                    $threeQuartersPremium = $priceRate->price;
                } else if($priceRate->num_of_quarters == 4) {
                    $fourQuartersPremium = $priceRate->price;
                }
            }

            $computations = array(
                new MotorInsuranceQuarterListComputations($startDate->toDateString(), $quarterList['quarter_one']->getLastQuarterDate(), $oneQuarterPremium, 1, $quarterOnePeriod),
                new MotorInsuranceQuarterListComputations($startDate->toDateString(), $quarterList['quarter_two']->getLastQuarterDate(), $twoQuartersPremium, 2, $quarterTwoPeriod),
                new MotorInsuranceQuarterListComputations($startDate->toDateString(), $quarterList['quarter_three']->getLastQuarterDate(), $threeQuartersPremium, 3, $quarterThreePeriod),
                new MotorInsuranceQuarterListComputations($startDate->toDateString(), $quarterList['quarter_four']->getLastQuarterDate(), $fourQuartersPremium, 4, $quarterFourPeriod),
            );

            $response['status'] = true;
            $response['computations'] = $computations;

            return $response;
        }

        catch(Exception $e) {
            $response['status'] = false;
            $response['message'] = "Error! {$e->getMessage()}";

            return $response;
        }
    }

    private function generateQuarterList($date)
    {
        $quarter1 = $date;
        $quarter2 = $date->copy()->addQuarters(1);
        $quarter3 = $date->copy()->addQuarters(2);
        $quarter4 = $date->copy()->addQuarters(3);


        $quarterOne = new DateDetails($quarter1);
        $quarterTwo = new DateDetails($quarter2);
        $quarterThree = new DateDetails($quarter3);
        $quarterFour = new DateDetails($quarter4);

        return array(
            'quarter_one' => $quarterOne,
            'quarter_two' => $quarterTwo,
            'quarter_three' => $quarterThree,
            'quarter_four' => $quarterFour,
        );
    }

    private function calculatePeriod($startDate, $endDate, $durationType)
    {
        if($durationType == "days") {
            return $startDate->diffInDays($endDate, false);
        } else if($durationType == "months") {
            return $startDate->diffInMonths($endDate, false);
        } else if($durationType == "years") {
            return $startDate->diffInYears($endDate, false);
        }
    }

    public function calculateHouseOwnersPremium($houseValue, $rate)
    {
        $premium = $houseValue * ($rate / 100);
        $levy = $premium * (3 / 100);

        return $premium + $levy;


    }


}

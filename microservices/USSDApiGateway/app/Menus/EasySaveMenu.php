<?php


namespace App\Menus;

use App\Config\UssdConfig;
use Carbon\Carbon;

class EasySaveMenu
{
    public function registrationRequestPage($prefix = null)
    {
        return $prefix ." Welcome to the EasySave Wallet service. Register to access services\n"
        ."1. Register\n"
        ."2. How it works\n";
    }

    public function confirmRegistrationPage($prefix = null)
    {
        return $prefix ." Accept terms and conditions\n"
            ."1. Confirm registration\n"
            ."2. Return to Main Menu\n";
    }

    public function easySaveInformationExitPage($prefix = null)
    {
        return $prefix ."Thank you for using EasySave. EasySave information"
            ." will be sent to you via sms shortly\n";
    }

    public function easySaveRegistrationThankYouPage($prefix = null)
    {
        return $prefix ."Thank you for using EasySave. "
            ."Your registration request is being processed and you "
            ."will receive a confirmation message shortly.";
    }

    public function easySaveRegistrationErrorPage($prefix = null)
    {
        return $prefix ."An Error Occurred. Please try again later\n";
    }

    public function easySaveMainMenuPage($prefix = null)
    {
        return $prefix ." Easy Save Wallet\n"
            ."1. View Savings\n"
            ."2. Maturity Date\n"
            ."3. Configure Mode of Savings\n"
            ."4. Request De-registration\n";
    }

    public function exitPage($prefix = null)
    {
        return $prefix ."Thank you for\n"
            ."using Professional Insurance.\n"
            ."Your wise choice.\n";
    }

    public function policyPurchaseThankYouPage($prefix = null)
    {
        return $prefix ."Thank you for using Professional Insurance. "
            ."Please visit any PICZ branch to collect your certificate.\n"
            ."Your wise choice.\n";
    }

    public function quotationRequestThankYouPage($prefix = null)
    {
        return $prefix ."Thank you for using Professional Insurance. "
            ."Your request is being processed and you "
            ."will receive a quotation message shortly.";
    }

    public function policyPurchaseErrorPage($prefix = null)
    {
        return $prefix ."An Error Occurred. Please Contact PICZ on:\n"
            ."Email : customerservice@picz.co.zm\n"
            ."Phone: +260 211 366 703\n"
            ."Whatsapp: +260 956 659 857\n";
    }

    public function landingPage($prefix = null)
    {
        return $prefix ."Welcome to PICZ "
            ."\nPlease select:\n"
            ."1. Buy Policy/Get Quote"
            ."\n2. Customer Care";
    }

    public function selectInsuranceProductsPage($products, $prefix = null)
    {
        $counter = 1;
        $displayMessage = $prefix ."Select Insurance \n";

        foreach($products as $product) {
            $displayMessage .= $counter.".".$product->product_name."\n";
            $counter++;
        }

        $displayNavigationMessage = "Press ". UssdConfig::BACK_MENU_OPTION_CHARACTER ." to go Back or ". UssdConfig::EXIT_MENU_OPTION_CHARACTER ." to Exit";

        return $displayMessage.$displayNavigationMessage;
    }

    public function selectMTPCoverTypePage($mtpCoverTypes, $prefix = null)
    {
        $counter = 1;
        $displayMessage = $prefix ."Select cover type \n";

        foreach($mtpCoverTypes as $mtpCoverType) {
            $displayMessage .= $counter.".".$mtpCoverType->product_type_name."\n";
            $counter++;
        }

        $displayNavigationMessage = "Press ". UssdConfig::BACK_MENU_OPTION_CHARACTER ." to go Back or ". UssdConfig::EXIT_MENU_OPTION_CHARACTER ." to Exit";

        return $displayMessage.$displayNavigationMessage;
    }

    public function requestVehicleRegistrationNumberPage($prefix = null)
    {
        return $prefix . "Please enter your vehicle registration number"
            ."\ne.g (AAA1234)"
            ."\nPress ". UssdConfig::BACK_MENU_OPTION_CHARACTER ." to go Back or ". UssdConfig::EXIT_MENU_OPTION_CHARACTER ." to Exit";
    }

    public function requestVehicleMakeAndModelPage($prefix = null)
    {
        return $prefix . "Please enter your vehicle make and model"
            ."\ne.g (TOYOTA-HILUX)"
            ."\nPress ". UssdConfig::BACK_MENU_OPTION_CHARACTER ." to go Back or ". UssdConfig::EXIT_MENU_OPTION_CHARACTER ." to Exit";
    }

    public function requestCoverStartDatePage($prefix = null)
    {
        $todaysDate = Carbon::now()->format('d-m-yy');

        return $prefix . "Please enter cover start date"
            ."\n(dd-mm-yyyy) e.g ({$todaysDate})"
            ."\nPress ". UssdConfig::BACK_MENU_OPTION_CHARACTER ." to go Back or ". UssdConfig::EXIT_MENU_OPTION_CHARACTER ." to Exit";
    }

    public function selectNumberOfQuartersPage($computations, $prefix = null)
    {
        $counter = 1;
        $displayMessage = $prefix ."Select number of quarters \n";

        foreach($computations as $computation) {
            $displayMessage .= "{$counter}. {$computation->getNumberOfQuarters()} qtr - K{$computation->getPremium()} - {$computation->getEndDate()}\n";
            $counter++;
        }

        $displayNavigationMessage = "Press ". UssdConfig::BACK_MENU_OPTION_CHARACTER ." to go Back or ". UssdConfig::EXIT_MENU_OPTION_CHARACTER ." to Exit";

        return $displayMessage.$displayNavigationMessage;
    }

    public function confirmPolicyPurchasePage($transaction, $prefix = null)
    {
        return $prefix ." You have selected {$transaction->getProductType()}"
            ." cover for "
            .$transaction->getCoverPeriod()
            ." {$transaction->getCoverPeriodType()}(s) at "
            ."K"
            .$transaction->getPremium()
            ." beginning on "
            .$transaction->getCoverStartDate()->format('d-m-Y')
            ." valid until "
            .$transaction->getCoverEndDate()->format('d-m-Y')
            ."\n1. Proceed to pay"
            ."\n2. Receive quote by SMS"
            ."\n3. Cancel";
    }

    public function selectNumberOfMonthsPage($prefix = null)
    {
        return $prefix ." Select number of months "
            ."\n1. 1 month - K5"
            ."\n2. 3 month - K15"
            ."\n3. 6 month - K30"
            ."\n4. 9 month - K45"
            ."\n5. 12 month - K60";
    }

    public function requestBeneficiaryFullNamesPage($prefix = null)
    {
        return $prefix . "Please enter beneficiary full names"
            ."\ne.g (MIKE MUYEMBE)"
            ."\nPress ". UssdConfig::BACK_MENU_OPTION_CHARACTER ." to go Back or ". UssdConfig::EXIT_MENU_OPTION_CHARACTER ." to Exit";
    }

    public function requestBeneficiaryRelationshipPage($beneficiaryFullNames, $prefix = null)
    {
        return $prefix . "Please state you relationship with {$beneficiaryFullNames}"
            ."\ne.g (HUSBAND, COUSIN, BROTHER)"
            ."\nPress ". UssdConfig::BACK_MENU_OPTION_CHARACTER ." to go Back or ". UssdConfig::EXIT_MENU_OPTION_CHARACTER ." to Exit";
    }

    public function requestBeneficiaryContactPage($beneficiaryFullNames, $prefix = null)
    {
        return $prefix . " Please enter {$beneficiaryFullNames}'s phone number"
            ."\n e.g (09XXXXXXXX)"
            ."\nPress ". UssdConfig::BACK_MENU_OPTION_CHARACTER ." to go Back or ". UssdConfig::EXIT_MENU_OPTION_CHARACTER ." to Exit";
    }

    public function requestMobileMoneyPinPage($prefix = null)
    {
        return $prefix . " Please enter your mobile money pin"
            ."\n";
    }

    public function requestHouseUsagePage($prefix = null)
    {
        return $prefix ." Do you live in the house or do you rent out the house?"
            ."\n1. Live in the house"
            ."\n2. Rent out the house"
            ."\nPress ". UssdConfig::BACK_MENU_OPTION_CHARACTER ." to go Back or ". UssdConfig::EXIT_MENU_OPTION_CHARACTER ." to Exit";
    }

    public function requestHouseRoofingPage($prefix = null)
    {
        return $prefix ." Select roofing type of house?"
            ."\n1. Standard Roofing"
            ."\n2. Thatched Roofing"
            ."\nPress ". UssdConfig::BACK_MENU_OPTION_CHARACTER ." to go Back or ". UssdConfig::EXIT_MENU_OPTION_CHARACTER ." to Exit";
    }

    public function requestHouseValuePage($prefix = null)
    {
        return $prefix . "Enter value of house"
            ."\ne.g (200000)"
            ."\nPress ". UssdConfig::BACK_MENU_OPTION_CHARACTER ." to go Back or ". UssdConfig::EXIT_MENU_OPTION_CHARACTER ." to Exit";
    }
}

<?php


namespace App\Config;


class UssdConfig
{
    const SERVICE_CODE = "20011010";
    const PRODUCT_CODE = "product_code";
    const SELECTED_PRODUCT ="selected_product";
    const PLACE_OF_LOSS = "place_of_loss";
    const SERVICEID = "serviceID";

    const MTP = "Motor Thrid Party";
    const OTI ="Muende Bwino";
    const MB = "Overseas Travel Insurance";
    const HO = "House Owners Policy";
    const MB_START_DATE = "start_date";

    const SELECTED_SERVICE_CODE = "service_code";
    const PICZ_SHORT_CODE = "*266#";
    const serviceID = "serviceID";
    const BENE_MSISDN = "bene_msisdn";

    const MOTOR_THRID = "Motor Third Party";
    const TRAVEL_POLICY = "Overseas Travel";
    const HOUSE_OWNERS = "House Insurance";
    const MUENDE_BWINO = "Muende Bwino";

    const VEHICLE_TYPES = "vehicle_type";
    const VEHICLE_TYPE_CODE = "vehicle_type_code";
    const VEHICLE_TYPE_NAME = "vehicle_type_name";

    const QUARTER_LIST ="quarter_list";
    const QUARTERS = "quarters";
    const QUARTER_NAME = "quarter_name";
    const QUARTERS_LIST = "quarter_list";
    const QUARTER_CODE = "quarter_code";
    const TOTAL_AMOUNT = "total_amount";

    const START_DATE = "start_date";
    const FIRST_QUARTER = "01-01";
    const SECOND_QUARTER = "04-01";
    const THRID_QUARTER = "07-01";
    const FOURTH_QUARTER = "10-1";
    const END_DATE = "end_date";
    const ZERO_CHARATER = "0";

    const MB_DURATION_LIST = "mb_duration_list";
    const MB_DURATION = "mb_durations";
    const MB_DURATION_CODE = "mb_duration_code";
    const MB_DURATION_NAME = "mb_duration_name";
    const MUENDE_BWINO_DURATION = "muende_bwino_duration";

    const PLAN_LIST = "plan_list";
    const SELECTED_PLAN_CODE = "selected_plan_code";
    const PLAN_CODE = "plan_code";
    const PLAN_NAME = "plan_name";

    const DESTINATION_LIST = "destination_list";
    const SELECTED_DESTINATION_CODE = "select_destination_code";
    const DESTINATION_CODE = "destination_code";
    const DESTINATION_NAME = "destination_name";

    const MTP_PREFIX = "MTP";
    const OTI_PREFIX = "OTI";
    const HO_PREFIX = "HO";
    const MB_PREFIX = "MB";

    // const HOUSE OWNERS ="house_owners";
    const HOUSE_OWNER_POLICY_CODE = "200110103";
    const OCCUPANTS_LIST ="occupants";
    const SELECTED_OCCUPANTS_CODE ="selected_occupants_code";
    const OCCUPANTS_CODE ="occupants_code";
    const OCCUPANTS_NAME ="occupants_name";

    const ROOFING_LIST = "roofing_list";
    const SELECTED_ROOFING_CODE = "selected_roofing_code";
    const ROOFING_CODE = "roofing_code";
    const ROOFING_NAME = "roofing_name";
    const THATCHED_ROOFING_CODE = "Thatched Roofing";
    const PREMUIM_RATE = "premium_rate";
    const VALUE_OF_HOUSE = "value_of_house";


    const SELECTED_CLAIM = "selected_claim";
    // const SELECTED_CLAIM = "";
    const CLAIM_NAME = "claim_name";
    const CLAIM_LIST = "claim_list";

    const PRODUCT_LIST = "productList";
    const FIRST_NAME_KEY = "firstName";
    const IS_REINVESTMENT_TXN = "isReinvestmentTxn";
    const ROUND_OFF_WITHDRAW_CHARGE = "roundOffWithdrawCharge";
    const LAST_NAME_KEY = "lastname";
    const NRC_KEY = "nrcNumber";
    const NEXT_NODE_KEY = "nextFunction";
    const PREVIOUS_NODE_KEY = "previousFunction";
    const FUNCTION_TO_RUN_KEY = "functionToRun";
    const BACK_MENU_OPTION_CHARACTER = "97";
    const MAIN_MENU_OPTION_CHARACTER = "98";
    const EXIT_MENU_OPTION_CHARACTER = "99";
    const ONE_CHARACTER = "1";
    const TWO_CHARACTER = "2";
    const THREE_CHARACTER = "3";
    const FOUR_CHARACTER = "4";
    const FIVE_CHARACTER = "5";
    const SIX_CHARACTER = "6";
    const SEVEN_CHARACTER = "7";
    const EIGHT_CHARACTER = "8";
    const NINE_CHARACTER = "9";

    //LEVEL CONSTANTS
    const LEVEL_ZERO = 0;
    const LEVEL_ONE = 1;
    const LEVEL_TWO = 2;
    const LEVEL_THREE = 3;
    const LEVEL_FOUR = 4;
    const LEVEL_FIVE = 5;
    const LEVEL_SIX = 6;
    const LEVEL_SEVEN = 7;
    const LEVEL_EIGHT= 8;
    const LEVEL_NINE = 9;
    const LEVEL_TEN = 10;

    // const VEHICLE_TYPE = "vehicleType";
    const QUARTER = "quarter";
    const VEHICLE = "vehicle";
    const SUM_ENSURED = "sumInsured";

    //PICZ
    const VEHICLE_REG = "vehicleReg";
    const PASSPORT_NUM = "passportNumber";
    const OTI_DURATION = "otiDuration";
    // const HOUSE_VALUE = "houseValue";
    const VOUCHER_NUMBER = "voucherNumber";
    const CLAIM_NUMBER = "claimNumber";
    const TOTAL_PREMUIM = "totalPremium";
    const QUARTER_SELECTED = "quarteSelected";
    const SELECTED_PREMIUM= "selectePremium";
    const VEHICLE_TYPE = "vehicleType";
    const PRIVATE_VEHICLE = "private";
    const COMMERCIAL_VEHICLE = "commercial";
    const PUBLIC_VEHICLE = "bus/taxi";
    const TRAVEL_DAYS ="travel_days";
    const DURATION_GROUP = "duration_group";
    const TEN_CHARACTER = "10";
    const ELEVEN_CHARATER = "11";
    const FOURTEEN_CHARACTER = "14";
    const TWENTY_ONE_CHARACTER = "21";
    const TWENTY_EIGHT_CHARACTER = "28";
    const THIRTY_FIVE_CHARACTER = "35";
    const THIRTY_SIX_CHARACTER = "36";
    const FOURTY_SEVEN_CHARACTER = "47";
    const SIXTY_CHARACTER = "60";
    const SEVENTY_FIVE_CHARACTER = "75";
    const NINETY_CHARACTER = "90";
    const ONE_TWENTY_CHARACTER = "120";
    const ONE_FOUR_SEVEN_CHARACTER = "147";
    const ONE_EIGHT_ZERO_CHARACTER = "180";
    const AGE = "age";
    const AGE_GROUP = "age_group";
    const DESTINATION = "destination";
    const CANADA_AND_USA = "canada and usa";
    const OTHER_DESTINATION = "other";
    const OTI_PLAN = "oti_plan";
    const MAXIMUM_DAYS = "maximumDays";
    const TRAVEL_PLAN = "plan";
    const MAXIMUM_AGE = "age";
    const TRAVELLER = "traveller";
    const PLUS_ONE = "plus_one";


    const HOUSE_OWNER = "houseOwner";
    const OWNER ="house owner";
    const TENANT = "tenant";
    const HOUSE_VALUE = "house_value";
    const SELECTED_POLICY = "selected_policy";
    const ROOFING_TYPE = "roofing_type";
    const THATCHED_ROOFING = "thatched";
    const STANDARD_ROOFING = "standard";
    const DURATION ="duration";
    const MUENDE_BWINO_RATE = 0.167;
    const VOUCHER_STATUS = "voucher_status";
    const ACTIVE_STATUS = "active";
    const CLAIM_POLICY = "phone_number";
    const CLAIM_DATE = "claim_date";
    const LOCATION = "location";
    const CLAIM_POLICY_ID = "claim_policy_id";
    const CLAIM_ID = "claim_id";

    const CLAIM_STATUS = "claim_status";
    // const START_DATE = "start_date";
    const HOUSE_OWNERS_POLICY = "House Owners Policy";
    const PENDING_STATUS = "pending";
    const SETTLED_STATUS = "settled";
    const QUARTER_LENGTH = "quarter_length";
    const ONE_QUARTER = "1 quarter";
    const TWO_QUARTERS = "2 quarters";
    const THREE_QUARTERS = "3 quarters";
    const FOUR_QUARTERS = "4 quarters";
    const PHONE_NUMBER = "phone_number";
    const POLICY_HOLDER = "policy_holder";
    const OTHER_POLICY_HOLDER = "other";
    const OWNER_POLICY_HOLDER = "owner";
    const FIRST_NAME = "firstname";
    const LAST_NAME = "lastname";
    const BENEFICIARY_NRC = "nrc";
    const BENEFICIARY_NUMBER = "phone_number";
    const THIRTY_DAYS = "30 days";
    const MB_THIRTY_DAYS = "5";
    const NINETY_DAYS = "90 days";
    const MB_NINETY_DAYS = "15";
    const HUNDRED_EIGHTY_DAYS = "180 days";
    const MB_HUNDRED_EIGHTY_DAYS = "30";
    const THREE_HUNDRED_SIXTY_FIVE_DAYS = "365 days";
    const MB_THREE_HUNDRED_SIXTY_FIVE_DAYS = "61";
    const NINETY_NINE_CHARACTER = "99";
    // const MUENDE_BWINO = "Muende bwino";
    const POLICY_NUMBER = "policy_number";
    const PLUS_ONE_PASSPORT = "plus_one_passport";
    const REFEREMCE_NUMBER = "reference_number";
    const KWACHA_CURRENCY = "ZMW";
}

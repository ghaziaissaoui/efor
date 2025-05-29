<?php

if ( ! defined('ABSPATH')) {
    exit;
}

use SEOPressPro\Core\Kernel;

/**
 * Get a service.
 *
 * @since 4.3.0
 *
 * @param string $service
 *
 * @return object
 */
function seopress_pro_get_service($service) {
    return Kernel::getContainer()->getServiceByName($service);
}

/**
 * Enable Google Suggestions
 *
 * @since 5.0
 *
 * @param boolean true
 *
 * @return boolean
 */
add_filter('seopress_ui_metabox_google_suggest', '__return_true');

/**
 * Get Page Speed Mobile Score
 *
 * @since 5.3
 *
 * @return string
 * @param mixed $json
 * @param mixed $mobile
 * @param mixed $is_mobile
 */
function seopress_pro_get_ps_score($json, $is_mobile = false) {
    if ( ! is_array($json)) {
        return;
    }
    if (array_key_first($json) === 'error') {
        return;
    }

    $ps_score = $json['lighthouseResult']['categories']['performance']['score'] ? ($json['lighthouseResult']['categories']['performance']['score']) * 100 : '';
    if ($is_mobile === true) {
        $i18n = __('Mobile', 'wp-seopress-pro');
    } else {
        $i18n = __('Desktop', 'wp-seopress-pro');
    }

    if ($ps_score >= 0 && $ps_score < 49) {
        $class_score = 'red';
    } elseif ($ps_score >= 50 && $ps_score < 90) {
        $class_score = 'yellow';
    } elseif ($ps_score >= 90 && $ps_score <= 100) {
        $class_score = 'green';
    } else {
        $class_score = 'grey';
    }

    $perf_score = '<div class="wrap-chart">
    <p>' . $i18n . '</p>
        <div class="ps-score ' . $class_score . '">
            <svg role="img" aria-hidden="true" focusable="false" width="100%" height="100%" viewBox="0 0 36 36" version="1.1" xmlns="http://www.w3.org/2000/svg">
                <path stroke-dasharray="100, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                <path id="bar" stroke-dasharray="' . $ps_score . ', 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"></path>
            </svg>
            <span>' . $ps_score . '%</span>
        </div>
    </div>';

    return $perf_score;
}

/**
 * Get Core Web Vitals Score
 *
 * @since 5.3
 *
 * @return string
 * @param mixed $json
 */
function seopress_pro_get_cwv_score($json) {
    if (array_key_first($json) === 'error') {
        return;
    }
    $core_web_vitals_score = false;

    if ( ! isset($json['loadingExperience']['metrics'])) {
        return $core_web_vitals_score = null;
    }

    if (
                    (isset($json['loadingExperience']['metrics']['FIRST_INPUT_DELAY_MS']['category']) && $json['loadingExperience']['metrics']['FIRST_INPUT_DELAY_MS']['category'] === 'FAST') &&
                (isset($json['loadingExperience']['metrics']['LARGEST_CONTENTFUL_PAINT_MS']['category']) && $json['loadingExperience']['metrics']['LARGEST_CONTENTFUL_PAINT_MS']['category'] === 'FAST') &&
                (isset($json['loadingExperience']['metrics']['CUMULATIVE_LAYOUT_SHIFT_SCORE']['category']) && $json['loadingExperience']['metrics']['CUMULATIVE_LAYOUT_SHIFT_SCORE']['category'] === 'FAST')) {
        $core_web_vitals_score = true;
    } elseif (
                    (isset($json['loadingExperience']['metrics']['LARGEST_CONTENTFUL_PAINT_MS']['category']) && $json['loadingExperience']['metrics']['LARGEST_CONTENTFUL_PAINT_MS']['category'] === 'FAST') &&
                    (isset($json['loadingExperience']['metrics']['CUMULATIVE_LAYOUT_SHIFT_SCORE']['category']) && $json['loadingExperience']['metrics']['CUMULATIVE_LAYOUT_SHIFT_SCORE']['category'] === 'FAST')
                ) {
        $core_web_vitals_score = true;
    }

    return $core_web_vitals_score;
}

/**
 * Get GA Dashboard widget option
 *
 * @since 5.3
 *
 * @return string
 */
function seopress_google_analytics_dashboard_widget_option() {
    $seopress_google_analytics_dashboard_widget_option = get_option('seopress_google_analytics_option_name');
    if ( ! empty($seopress_google_analytics_dashboard_widget_option)) {
        foreach ($seopress_google_analytics_dashboard_widget_option as $key => $seopress_google_analytics_dashboard_widget_value) {
            $options[$key] = $seopress_google_analytics_dashboard_widget_value;
        }
        if (isset($seopress_google_analytics_dashboard_widget_option['seopress_google_analytics_dashboard_widget'])) {
            return $seopress_google_analytics_dashboard_widget_option['seopress_google_analytics_dashboard_widget'];
        }
    }
}

/**
 * Get GA Dashboard widget role option
 *
 * @return string
 */
function seopress_advanced_security_ga_widget_role_option() {
    $service = seopress_get_service('AdvancedOption');

    if ( ! empty($service) || ! method_exists($service, 'getSecurityGaWidgetRole')) {
        $data = get_option('seopress_advanced_option_name');
        if (isset($data['seopress_advanced_security_ga_widget_role'])) {
            return $data['seopress_advanced_security_ga_widget_role'];
        }
    }

    return $service->getSecurityGaWidgetRole();
}

/**
 * Check GA Dashboard widget capability
 *
 * @return boolean
 */
function seopress_advanced_security_ga_widget_check() {
    if (empty(seopress_advanced_security_ga_widget_role_option())) {
        $seopress_ga_dashboard_widget_cap = 'edit_dashboard';
        $seopress_ga_dashboard_widget_cap = apply_filters('seopress_ga_dashboard_widget_cap', $seopress_ga_dashboard_widget_cap);

        return current_user_can($seopress_ga_dashboard_widget_cap);
    }

    global $wp_roles;

    //Get current user role
    if ( ! isset(wp_get_current_user()->roles[0])) {
        return;
    }
    $seopress_user_role = wp_get_current_user()->roles[0];

    if (array_key_exists($seopress_user_role, seopress_advanced_security_ga_widget_role_option())) {
        return true;
    }

    return;
}

/**
 * Get Matomo Dashboard widget option
 *
 * @since 6.0
 *
 * @return string
 */
function seopress_google_analytics_matomo_dashboard_widget_option() {
    $seopress_google_analytics_dashboard_widget_option = get_option('seopress_google_analytics_option_name');
    if ( ! empty($seopress_google_analytics_dashboard_widget_option)) {
        foreach ($seopress_google_analytics_dashboard_widget_option as $key => $seopress_google_analytics_dashboard_widget_value) {
            $options[$key] = $seopress_google_analytics_dashboard_widget_value;
        }
        if (isset($seopress_google_analytics_dashboard_widget_option['seopress_google_analytics_matomo_dashboard_widget'])) {
            return $seopress_google_analytics_dashboard_widget_option['seopress_google_analytics_matomo_dashboard_widget'];
        }
    }
}

/**
 * Get Matomo Dashboard widget role option
 *
 * @since 6.0
 *
 * @return string
 */
function seopress_advanced_security_matomo_widget_role_option() {
    $service = seopress_get_service('AdvancedOption');

    if ( ! empty($service) || ! method_exists($service, 'getSecurityMatomoWidgetRole')) {
        $data = get_option('seopress_advanced_option_name');
        if (isset($data['seopress_advanced_security_matomo_widget_role'])) {
            return $data['seopress_advanced_security_matomo_widget_role'];
        }
    }

    return $service->getSecurityMatomoWidgetRole();
}

/**
 * Check Matomo Dashboard widget capability
 *
 * @since 6.0
 *
 * @return boolean
 */
function seopress_advanced_security_matomo_widget_check() {
    if (empty(seopress_advanced_security_matomo_widget_role_option())) {
        $cap = 'edit_dashboard';
        $cap = apply_filters('seopress_matomo_dashboard_widget_cap', $cap);

        return current_user_can($cap);
    }

    global $wp_roles;

    //Get current user role
    if ( ! isset(wp_get_current_user()->roles[0])) {
        return;
    }
    $seopress_user_role = wp_get_current_user()->roles[0];

    if (array_key_exists($seopress_user_role, seopress_advanced_security_matomo_widget_role_option())) {
        return true;
    }

    return;
}

/**
 * Retrocompatibility for PHP < 8.0
 */
if ( ! function_exists('str_starts_with')) {
    function str_starts_with($haystack, $needle) {
        return (string)$needle !== '' && strncmp($haystack, $needle, strlen($needle)) === 0;
    }
}

/**
 * Get LB types list
 */
function seopress_lb_types_list() {
    $seopress_lb_types = [
        'LocalBusiness' => __('Local Business (default)', 'wp-seopress-pro'),
        'AnimalShelter' => __('Animal Shelter', 'wp-seopress-pro'),
        'AutomotiveBusiness' => __('Automotive Business', 'wp-seopress-pro'),
        'AutoBodyShop' => __('|-Auto Body Shop', 'wp-seopress-pro'),
        'AutoDealer' => __('|-Auto Dealer', 'wp-seopress-pro'),
        'AutoPartsStore' => __('|-Auto Parts Store', 'wp-seopress-pro'),
        'AutoRental' => __('|-Auto Rental', 'wp-seopress-pro'),
        'AutoRepair' => __('|-Auto Repair', 'wp-seopress-pro'),
        'AutoWash' => __('|-AutoWash', 'wp-seopress-pro'),
        'GasStation' => __('|-Gas Station', 'wp-seopress-pro'),
        'MotorcycleDealer' => __('|-Motorcycle Dealer', 'wp-seopress-pro'),
        'MotorcycleRepair' => __('|-Motorcycle Repair', 'wp-seopress-pro'),
        'ChildCare' => __('Child Care', 'wp-seopress-pro'),
        'DryCleaningOrLaundry' => __('Dry Cleaning Or Laundry', 'wp-seopress-pro'),
        'EmergencyService' => __('Emergency Service', 'wp-seopress-pro'),
        'FireStation' => __('|-Fire Station', 'wp-seopress-pro'),
        'Hospital' => __('|-Hospital', 'wp-seopress-pro'),
        'PoliceStation' => __('|-Police Station', 'wp-seopress-pro'),
        'EmploymentAgency' => __('Employment Agency', 'wp-seopress-pro'),
        'EntertainmentBusiness' => __('Entertainment Business', 'wp-seopress-pro'),
        'AdultEntertainment' => __('|-Adult Entertainment', 'wp-seopress-pro'),
        'AmusementPark' => __('|-Amusement Park', 'wp-seopress-pro'),
        'ArtGallery' => __('|-Art Gallery', 'wp-seopress-pro'),
        'Casino' => __('|-Casino', 'wp-seopress-pro'),
        'ComedyClub' => __('|-Comedy Club', 'wp-seopress-pro'),
        'MovieTheater' => __('|-Movie Theater', 'wp-seopress-pro'),
        'NightClub' => __('|-Night Club', 'wp-seopress-pro'),
        'FinancialService' => __('Financial Service', 'wp-seopress-pro'),
        'AccountingService' => __('|-Accounting Service', 'wp-seopress-pro'),
        'AutomatedTeller' => __('|-Automated Teller', 'wp-seopress-pro'),
        'BankOrCreditUnion' => __('|-Bank Or Credit Union', 'wp-seopress-pro'),
        'InsuranceAgency' => __('|-Insurance Agency', 'wp-seopress-pro'),
        'FoodEstablishment' => __('Food Establishment', 'wp-seopress-pro'),
        'Bakery' => __('|-Bakery', 'wp-seopress-pro'),
        'BarOrPub' => __('|-Bar Or Pub', 'wp-seopress-pro'),
        'Brewery' => __('|-Brewery', 'wp-seopress-pro'),
        'CafeOrCoffeeShop' => __('|-Cafe Or Coffee Shop', 'wp-seopress-pro'),
        'FastFoodRestaurant' => __('|-Fast Food Restaurant', 'wp-seopress-pro'),
        'IceCreamShop' => __('|-Ice Cream Shop', 'wp-seopress-pro'),
        'Restaurant' => __('|-Restaurant', 'wp-seopress-pro'),
        'Winery' => __('|-Winery', 'wp-seopress-pro'),
        'GovernmentOffice' => __('Government Office', 'wp-seopress-pro'),
        'PostOffice' => __('|-PostOffice', 'wp-seopress-pro'),
        'HealthAndBeautyBusiness' => __('Health And Beauty Business', 'wp-seopress-pro'),
        'BeautySalon' => __('|-Beauty Salon', 'wp-seopress-pro'),
        'DaySpa' => __('|-Day Spa', 'wp-seopress-pro'),
        'HairSalon' => __('|-Hair Salon', 'wp-seopress-pro'),
        'HealthClub' => __('|-Health Club', 'wp-seopress-pro'),
        'NailSalon' => __('|-Nail Salon', 'wp-seopress-pro'),
        'TattooParlor' => __('|-Tattoo Parlor', 'wp-seopress-pro'),
        'HomeAndConstructionBusiness' => __('Home And Construction Business', 'wp-seopress-pro'),
        'Electrician' => __('|-Electrician', 'wp-seopress-pro'),
        'HVACBusiness' => __('|-HVAC Business', 'wp-seopress-pro'),
        'HousePainter' => __('|-House Painter', 'wp-seopress-pro'),
        'Locksmith' => __('|-Locksmith', 'wp-seopress-pro'),
        'MovingCompany' => __('|-Moving Company', 'wp-seopress-pro'),
        'Plumber' => __('|-Plumber', 'wp-seopress-pro'),
        'RoofingContractor' => __('|-Roofing Contractor', 'wp-seopress-pro'),
        'InternetCafe' => __('Internet Cafe', 'wp-seopress-pro'),
        'MedicalBusiness' => __('Medical Business', 'wp-seopress-pro'),
        'CommunityHealth' => __('|-Community Health', 'wp-seopress-pro'),
        'Dentist' => __('|-Dentist', 'wp-seopress-pro'),
        'Dermatology' => __('|-Dermatology', 'wp-seopress-pro'),
        'DietNutrition' => __('|-Diet Nutrition', 'wp-seopress-pro'),
        'Emergency' => __('|-Emergency', 'wp-seopress-pro'),
        'Gynecologic' => __('|-Gynecologic', 'wp-seopress-pro'),
        'MedicalClinic' => __('|-Medical Clinic', 'wp-seopress-pro'),
        'Midwifery' => __('|-Midwifery', 'wp-seopress-pro'),
        'Nursing' => __('|-Nursing', 'wp-seopress-pro'),
        'Obstetric' => __('|-Obstetric', 'wp-seopress-pro'),
        'Oncologic' => __('|-Oncologic', 'wp-seopress-pro'),
        'Optician' => __('|-Optician', 'wp-seopress-pro'),
        'Optometric' => __('|-Optometric', 'wp-seopress-pro'),
        'Otolaryngologic' => __('|-Otolaryngologic', 'wp-seopress-pro'),
        'Pediatric' => __('|-Pediatric', 'wp-seopress-pro'),
        'Pharmacy' => __('|-Pharmacy', 'wp-seopress-pro'),
        'Physician' => __('|-Physician', 'wp-seopress-pro'),
        'Physiotherapy' => __('|-Physiotherapy', 'wp-seopress-pro'),
        'PlasticSurgery' => __('|-Plastic Surgery', 'wp-seopress-pro'),
        'Podiatric' => __('|-Podiatric', 'wp-seopress-pro'),
        'PrimaryCare' => __('|-Primary Care', 'wp-seopress-pro'),
        'Psychiatric' => __('|-Psychiatric', 'wp-seopress-pro'),
        'PublicHealth' => __('|-Public Health', 'wp-seopress-pro'),
        'VeterinaryCare' => __('|-Veterinary Care', 'wp-seopress-pro'),
        'LegalService' => __('Legal Service', 'wp-seopress-pro'),
        'Attorney' => __('|-Attorney', 'wp-seopress-pro'),
        'Notary' => __('|-Notary', 'wp-seopress-pro'),
        'Library' => __('Library', 'wp-seopress-pro'),
        'LodgingBusiness' => __('Lodging Business', 'wp-seopress-pro'),
        'BedAndBreakfast' => __('|-Bed And Breakfast', 'wp-seopress-pro'),
        'Campground' => __('|-Campground', 'wp-seopress-pro'),
        'Hostel' => __('|-Hostel', 'wp-seopress-pro'),
        'Hotel' => __('|-Hotel', 'wp-seopress-pro'),
        'Motel' => __('|-Motel', 'wp-seopress-pro'),
        'Resort' => __('|-Resort', 'wp-seopress-pro'),
        'ProfessionalService' => __('Professional Service', 'wp-seopress-pro'),
        'RadioStation' => __('Radio Station', 'wp-seopress-pro'),
        'RealEstateAgent' => __('Real Estate Agent', 'wp-seopress-pro'),
        'RecyclingCenter' => __('Recycling Center', 'wp-seopress-pro'),
        'SelfStorage' => __('Real Self Storage', 'wp-seopress-pro'),
        'ShoppingCenter' => __('Shopping Center', 'wp-seopress-pro'),
        'SportsActivityLocation' => __('Sports Activity Location', 'wp-seopress-pro'),
        'BowlingAlley' => __('|-Bowling Alley', 'wp-seopress-pro'),
        'ExerciseGym' => __('|-Exercise Gym', 'wp-seopress-pro'),
        'GolfCourse' => __('|-Golf Course', 'wp-seopress-pro'),
        'HealthClub' => __('|-Health Club', 'wp-seopress-pro'),
        'PublicSwimmingPool' => __('|-Public Swimming Pool', 'wp-seopress-pro'),
        'SkiResort' => __('|-Ski Resort', 'wp-seopress-pro'),
        'SportsClub' => __('|-Sports Club', 'wp-seopress-pro'),
        'StadiumOrArena' => __('|-Stadium Or Arena', 'wp-seopress-pro'),
        'TennisComplex' => __('|-Tennis Complex', 'wp-seopress-pro'),
        'Store' => __('Store', 'wp-seopress-pro'),
        'AutoPartsStore' => __('|-Auto Parts Store', 'wp-seopress-pro'),
        'BikeStore' => __('|-Bike Store', 'wp-seopress-pro'),
        'BookStore' => __('|-Book Store', 'wp-seopress-pro'),
        'ClothingStore' => __('|-Clothing Store', 'wp-seopress-pro'),
        'ComputerStore' => __('|-Computer Store', 'wp-seopress-pro'),
        'ConvenienceStore' => __('|-Convenience Store', 'wp-seopress-pro'),
        'DepartmentStore' => __('|-Department Store', 'wp-seopress-pro'),
        'ElectronicsStore' => __('|-Electronics Store', 'wp-seopress-pro'),
        'Florist' => __('|-Florist', 'wp-seopress-pro'),
        'FurnitureStore' => __('|-Furniture Store', 'wp-seopress-pro'),
        'GardenStore' => __('|-Garden Store', 'wp-seopress-pro'),
        'GroceryStore' => __('|-Grocery Store', 'wp-seopress-pro'),
        'HardwareStore' => __('|-Hardware Store', 'wp-seopress-pro'),
        'HobbyShop' => __('|-Hobby Shop', 'wp-seopress-pro'),
        'HomeGoodsStore' => __('|-Home Goods Store', 'wp-seopress-pro'),
        'JewelryStore' => __('|-Jewelry Store', 'wp-seopress-pro'),
        'LiquorStore' => __('|-Liquor Store', 'wp-seopress-pro'),
        'MensClothingStore' => __('|-Mens Clothing Store', 'wp-seopress-pro'),
        'MobilePhoneStore' => __('|-Mobile Phone Store', 'wp-seopress-pro'),
        'MovieRentalStore' => __('|-Movie Rental Store', 'wp-seopress-pro'),
        'MusicStore' => __('|-Music Store', 'wp-seopress-pro'),
        'OfficeEquipmentStore' => __('|-Office Equipment Store', 'wp-seopress-pro'),
        'OutletStore' => __('|-Outlet Store', 'wp-seopress-pro'),
        'PawnShop' => __('|-Pawn Shop', 'wp-seopress-pro'),
        'PetStore' => __('|-Pet Store', 'wp-seopress-pro'),
        'ShoeStore' => __('|-Shoe Store', 'wp-seopress-pro'),
        'SportingGoodsStore' => __('|-Sporting Goods Store', 'wp-seopress-pro'),
        'TireShop' => __('|-Tire Shop', 'wp-seopress-pro'),
        'ToyStore' => __('|-Toy Store', 'wp-seopress-pro'),
        'WholesaleStore' => __('|-Wholesale Store', 'wp-seopress-pro'),
        'TelevisionStation' => __('|-Wholesale Store', 'wp-seopress-pro'),
        'TouristInformationCenter' => __('Tourist Information Center', 'wp-seopress-pro'),
        'TravelAgency' => __('Travel Agency', 'wp-seopress-pro'),
    ];

    $seopress_lb_types = apply_filters('seopress_schemas_lb_types', $seopress_lb_types);

    return $seopress_lb_types;
}

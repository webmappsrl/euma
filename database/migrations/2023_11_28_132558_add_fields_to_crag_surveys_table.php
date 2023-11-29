<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // columns: created_at	member_name	respondent_name_and_role	respondent_mail	climbing_frequency	equipping_routes_frequency	managing_rock_climbing_areas_frequency	most_popular_climbing_spot	managing_rock_climbing_areas_description	other_groups_managing_rock_climbing_areas_description	money_source_bolting_infrastructure	legal_responsibility_equippers	rock_climbing_areas_bans	rock_climbing_areas_limitations	limitations_imposing_authority	limitations_efficiency	micro_zoning_examples	disputes_nature_protection	disputes_local_population	disputes_overcrowding	disputes_ownership	disputes_access	disputes_littering	disputes_wild_camping	other_problems	liability_climbing_accidents	good_practice_examples	bad_practice_examples	is_climbing_tourism_country	climbing_destination_season_preferred_regions_countries	regions_with_significant_climbing_tourism_income	crags_developed_with_tourism_funds	experiences_with_climbing_tourists	countries_visited_by_climbers	tourist_associations_promoting_climbing	assessing_climbing_tourism_potential	official_climbing_ethics	obedience_to_climbing_ethics	area_specific_climbing_ethics	bolting_licences_and_manuals	responsibility_for_equipment_failure	potential_for_new_climbing_areas	cooperation_with_climbing_stakeholders	cooperation_with_non_climbing_stakeholders	association_involvement_outdoor_rock_climbing_area	procedure_to_create_new_climbing_areas	statistics_databases_rock_climbing_areas	guidebooks_in_country	other_sources_on_rock_climbing	estimated_people_sport_climbing	estimated_people_climbing_in_gym	estimated_people_bouldering	estimated_people_alpine_climbing	estimated_people_ice_climbing	estimated_people_drytooling	estimated_people_via_ferrata	trends_sport_climbing	trends_gym_climbing	trends_bouldering 
        // trends_alpine_climbing	trends_ice_climbing_dry_tooling	other_climbing_sport_trends	significance_of_trad_aid_climbing	development_of_climbers_in_last_20_years	number_of_climbing_gyms	artificial_climbing_infrastructure_description	association_members_climbers	people_climbing_in_country	is_official_number	number_of_rock_climbing_areas	number_of_bouldering_spots_problems	other_climbing_related_sports	additional_information	
        Schema::table('crag_surveys', function (Blueprint $table) {
            $table->timestamp('created_at')->nullable();
            $table->string('respondent_name_and_role', 2000)->nullable();
            $table->string('respondent_mail', 2000)->nullable();
            $table->string('climbing_frequency', 2000)->nullable();
            $table->string('equipping_routes_frequency', 2000)->nullable();
            $table->string('managing_rock_climbing_areas_frequency', 2000)->nullable();
            $table->string('most_popular_climbing_spot', 2000)->nullable();
            $table->string('managing_rock_climbing_areas_description', 2000)->nullable();
            $table->string('other_groups_managing_rock_climbing_areas_description', 2000)->nullable();
            $table->string('money_source_bolting_infrastructure', 2000)->nullable();
            $table->string('legal_responsibility_equippers', 2000)->nullable();
            $table->string('rock_climbing_areas_bans', 2000)->nullable();
            $table->string('rock_climbing_areas_limitations', 2000)->nullable();
            $table->string('limitations_imposing_authority', 2000)->nullable();
            $table->string('limitations_efficiency', 2000)->nullable();
            $table->string('micro_zoning_examples', 2000)->nullable();
            $table->string('disputes_nature_protection', 2000)->nullable();
            $table->string('disputes_local_population', 2000)->nullable();
            $table->string('disputes_overcrowding', 2000)->nullable();
            $table->string('disputes_ownership', 2000)->nullable();
            $table->string('disputes_access', 2000)->nullable();
            $table->string('disputes_littering', 2000)->nullable();
            $table->string('disputes_wild_camping', 2000)->nullable();
            $table->string('other_problems', 2000)->nullable();
            $table->string('liability_climbing_accidents', 2000)->nullable();
            $table->string('good_practice_examples', 2000)->nullable();
            $table->string('bad_practice_examples', 2000)->nullable();
            $table->string('is_climbing_tourism_country', 2000)->nullable();
            $table->string('climbing_destination_season_preferred_regions_countries', 2000)->nullable();
            $table->string('regions_with_significant_climbing_tourism_income', 2000)->nullable();
            $table->string('crags_developed_with_tourism_funds', 2000)->nullable();
            $table->string('experiences_with_climbing_tourists', 2000)->nullable();
            $table->string('countries_visited_by_climbers', 2000)->nullable();
            $table->string('tourist_associations_promoting_climbing', 2000)->nullable();
            $table->string('assessing_climbing_tourism_potential', 2000)->nullable();
            $table->string('official_climbing_ethics', 2000)->nullable();
            $table->string('obedience_to_climbing_ethics', 2000)->nullable();
            $table->string('area_specific_climbing_ethics', 2000)->nullable();
            $table->string('bolting_licences_and_manuals', 2000)->nullable();
            $table->string('responsibility_for_equipment_failure', 2000)->nullable();
            $table->string('potential_for_new_climbing_areas', 2000)->nullable();
            $table->string('cooperation_with_climbing_stakeholders', 2000)->nullable();
            $table->string('cooperation_with_non_climbing_stakeholders', 2000)->nullable();
            $table->string('association_involvement_outdoor_rock_climbing_area', 2000)->nullable();
            $table->string('procedure_to_create_new_climbing_areas', 2000)->nullable();
            $table->string('statistics_databases_rock_climbing_areas', 2000)->nullable();
            $table->string('guidebooks_in_country', 2000)->nullable();
            $table->string('other_sources_on_rock_climbing', 2000)->nullable();
            $table->string('estimated_people_sport_climbing', 2000)->nullable();
            $table->string('estimated_people_climbing_in_gym', 2000)->nullable();
            $table->string('estimated_people_bouldering', 2000)->nullable();
            $table->string('estimated_people_alpine_climbing', 2000)->nullable();
            $table->string('estimated_people_ice_climbing', 2000)->nullable();
            $table->string('estimated_people_drytooling', 2000)->nullable();
            $table->string('estimated_people_via_ferrata', 2000)->nullable();
            $table->string('trends_sport_climbing', 2000)->nullable();
            $table->string('trends_gym_climbing', 2000)->nullable();
            $table->string('trends_bouldering', 2000)->nullable();
            $table->string('trends_alpine_climbing', 2000)->nullable();
            $table->string('trends_ice_climbing_dry_tooling', 2000)->nullable();
            $table->string('other_climbing_sport_trends', 2000)->nullable();
            $table->string('significance_of_trad_aid_climbing', 2000)->nullable();
            $table->string('development_of_climbers_in_last_20_years', 2000)->nullable();
            $table->string('number_of_climbing_gyms', 2000)->nullable();
            $table->string('artificial_climbing_infrastructure_description', 2000)->nullable();
            $table->string('association_members_climbers', 2000)->nullable();
            $table->string('people_climbing_in_country', 2000)->nullable();
            $table->string('is_official_number', 2000)->nullable();
            $table->string('number_of_rock_climbing_areas', 2000)->nullable();
            $table->string('number_of_bouldering_spots_problems', 2000)->nullable();
            $table->string('other_climbing_related_sports', 2000)->nullable();
            $table->string('additional_information', 2000)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crag_surveys', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('respondent_name_and_role');
            $table->dropColumn('respondent_mail');
            $table->dropColumn('climbing_frequency');
            $table->dropColumn('equipping_routes_frequency');
            $table->dropColumn('managing_rock_climbing_areas_frequency');
            $table->dropColumn('most_popular_climbing_spot');
            $table->dropColumn('managing_rock_climbing_areas_description');
            $table->dropColumn('other_groups_managing_rock_climbing_areas_description');
            $table->dropColumn('money_source_bolting_infrastructure');
            $table->dropColumn('legal_responsibility_equippers');
            $table->dropColumn('rock_climbing_areas_bans');
            $table->dropColumn('rock_climbing_areas_limitations');
            $table->dropColumn('limitations_imposing_authority');
            $table->dropColumn('limitations_efficiency');
            $table->dropColumn('micro_zoning_examples');
            $table->dropColumn('disputes_nature_protection');
            $table->dropColumn('disputes_local_population');
            $table->dropColumn('disputes_overcrowding');
            $table->dropColumn('disputes_ownership');
            $table->dropColumn('disputes_access');
            $table->dropColumn('disputes_littering');
            $table->dropColumn('disputes_wild_camping');
            $table->dropColumn('other_problems');
            $table->dropColumn('liability_climbing_accidents');
            $table->dropColumn('good_practice_examples');
            $table->dropColumn('bad_practice_examples');
            $table->dropColumn('is_climbing_tourism_country');
            $table->dropColumn('climbing_destination_season_preferred_regions_countries');
            $table->dropColumn('regions_with_significant_climbing_tourism_income');
            $table->dropColumn('crags_developed_with_tourism_funds');
            $table->dropColumn('experiences_with_climbing_tourists');
            $table->dropColumn('countries_visited_by_climbers');
            $table->dropColumn('tourist_associations_promoting_climbing');
            $table->dropColumn('assessing_climbing_tourism_potential');
            $table->dropColumn('official_climbing_ethics');
            $table->dropColumn('obedience_to_climbing_ethics');
            $table->dropColumn('area_specific_climbing_ethics');
            $table->dropColumn('bolting_licences_and_manuals');
            $table->dropColumn('responsibility_for_equipment_failure');
            $table->dropColumn('potential_for_new_climbing_areas');
            $table->dropColumn('cooperation_with_climbing_stakeholders');
            $table->dropColumn('cooperation_with_non_climbing_stakeholders');
            $table->dropColumn('association_involvement_outdoor_rock_climbing_area');
            $table->dropColumn('procedure_to_create_new_climbing_areas');
            $table->dropColumn('statistics_databases_rock_climbing_areas');
            $table->dropColumn('guidebooks_in_country');
            $table->dropColumn('other_sources_on_rock_climbing');
            $table->dropColumn('estimated_people_sport_climbing');
            $table->dropColumn('estimated_people_climbing_in_gym');
            $table->dropColumn('estimated_people_bouldering');
            $table->dropColumn('estimated_people_alpine_climbing');
            $table->dropColumn('estimated_people_ice_climbing');
            $table->dropColumn('estimated_people_drytooling');
            $table->dropColumn('estimated_people_via_ferrata');
            $table->dropColumn('trends_sport_climbing');
            $table->dropColumn('trends_gym_climbing');
            $table->dropColumn('trends_bouldering');
            $table->dropColumn('trends_alpine_climbing');
            $table->dropColumn('trends_ice_climbing_dry_tooling');
            $table->dropColumn('other_climbing_sport_trends');
            $table->dropColumn('significance_of_trad_aid_climbing');
            $table->dropColumn('development_of_climbers_in_last_20_years');
            $table->dropColumn('number_of_climbing_gyms');
            $table->dropColumn('artificial_climbing_infrastructure_description');
            $table->dropColumn('association_members_climbers');
            $table->dropColumn('people_climbing_in_country');
            $table->dropColumn('is_official_number');
            $table->dropColumn('number_of_rock_climbing_areas');
            $table->dropColumn('number_of_bouldering_spots_problems');
            $table->dropColumn('other_climbing_related_sports');
            $table->dropColumn('additional_information');
        });
    }
};

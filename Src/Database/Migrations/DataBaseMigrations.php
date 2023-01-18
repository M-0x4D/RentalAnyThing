<?php

namespace MvcCore\Rental\Database\Migrations;

use MvcCore\Rental\Database\Initialization\Migration;
        
    class DataBaseMigrations extends Migration
    {
        public function up()
        {
                $this->call([
                    CountryTable::class,
                    GovernrateTable::class,
                    CityTable::class,
                    PaymentApiCredentialsTable::class,
                    TokenParametersTable::class,
                    OrderLinksTable::class,
                    ColorsTable::class,
                    CategoriesTable::class,
                    RentalsTable::class,
                    ObjectsTable::class,
                    LabelsTable::class,
                    ImagesTable::class,
                    BanarImageTable::class,
                    DescriptionTable::class,
                    CurrenciesTable::class,
                    CacheModel::class
    
            ], 'up'); 
        }
    
    
        public function upExtention()
        {
            $this->call([
                CacheModel::class,
            ], 'up');
        }
    
        public function down()
        {
            $this->call([
            CountryTable::class,
            GovernrateTable::class,
            CityTable::class,
            PaymentApiCredentialsTable::class,
            TokenParametersTable::class,
            OrderLinksTable::class,
            ColorsTable::class,
            CategoriesTable::class,
            RentalsTable::class,
            ObjectsTable::class,
            LabelsTable::class,
            ImagesTable::class,
            BanarImageTable::class,
            DescriptionTable::class,
            CurrenciesTable::class,
            CacheModel::class

            ], 'down');
        }
    
    
        public function downExtention()
        {
            
            $this->call([
                CacheModel::class,
            ], 'down');
            
        }
    }
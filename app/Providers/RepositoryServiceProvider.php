<?php

namespace App\Providers;

use App\Models\Content;
use App\Models\ContentType;
use App\Models\ContentTypeCategory;
use App\Models\Duas;
use App\Models\DuasCategory;
use App\Models\HadithContent;
use App\Models\MetalConvertablePrice;
use App\Models\NewsPortal;
use App\Models\PaymentHistory;
use App\Models\Rules;
use App\Repositories\Calculation\CalculationRepository;
use App\Repositories\Calculation\CalculationRepositoryInterface;
use App\Repositories\ContentTypeCategory\ContentTypeCategoryRepository;
use App\Repositories\ContentTypeCategory\ContentTypeCategoryRepositoryInterface;
use App\Repositories\ContentType\ContentTypeRepository;
use App\Repositories\ContentType\ContentTypeRepositoryInterface;
use App\Repositories\Content\ContentRepository;
use App\Repositories\Content\ContentRepositoryInterface;
use App\Repositories\Converter\ConverterRepository;
use App\Repositories\Converter\ConverterRepositoryInterface;
use App\Repositories\Dua\DuaRepository;
use App\Repositories\Dua\DuaRepositoryInterface;
use App\Repositories\Educative\EducativeRepository;
use App\Repositories\Educative\EducativeRepositoryInterface;
use App\Repositories\Hadith\HadithRepository;
use App\Repositories\Hadith\HadithRepositoryInterface;
use App\Repositories\lifeStyle\LifeStyleRepository;
use App\Repositories\lifeStyle\LifeStyleRepositoryInterface;
use App\Repositories\MetalPrice\MetalPriceRepository;
use App\Repositories\MetalPrice\MetalPriceRepositoryInterface;
use App\Repositories\Namaz\NamazRepository;
use App\Repositories\Namaz\NamazRepositoryInterface;
use App\Repositories\NewsPortal\NewsPortalRepository;
use App\Repositories\NewsPortal\NewsPortalRepositoryInterface;
use App\Repositories\PaymentHistory\PaymentHistoryRepository;
use App\Repositories\PaymentHistory\PaymentHistoryRepositoryInterface;
use App\Repositories\Quran\QuranRepository;
use App\Repositories\Quran\QuranRepositoryInterface;
use App\Repositories\Rules\RulesRepository;
use App\Repositories\Rules\RulesRepositoryInterface;
use App\Repositories\Zakat\ZakatRepository;
use App\Repositories\Zakat\ZakatRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Namaz Repository
        $this->app->singleton(NamazRepositoryInterface::class, function ($app) {
            return new NamazRepository();
        });

        // Zakat Repository
        $this->app->singleton(ZakatRepositoryInterface::class, function ($app) {
            return new ZakatRepository();
        });

        // All converter repository
        $this->app->singleton(ConverterRepositoryInterface::class, function ($app) {
            return new ConverterRepository();
        });

        // Calculation
        $this->app->singleton(CalculationRepositoryInterface::class, function ($app) {
            return new CalculationRepository(
                resolve(MetalPriceRepositoryInterface::class)
            );
        });

        // Metal Price
        $this->app->singleton(MetalPriceRepositoryInterface::class, function ($app) {
            return new MetalPriceRepository(new MetalConvertablePrice());
        });

        // Content Type
        $this->app->singleton(ContentTypeRepositoryInterface::class, function ($app) {
            return new ContentTypeRepository(new ContentType());
        });

        // Content Type Category
        $this->app->singleton(ContentTypeCategoryRepositoryInterface::class, function ($app) {
            return new ContentTypeCategoryRepository(
                new ContentTypeCategory(),
                resolve(ContentTypeRepositoryInterface::class)
            );
        });

        // life style
        $this->app->singleton(LifeStyleRepositoryInterface::class, function ($app) {
            return new LifeStyleRepository(
                resolve(ContentTypeCategoryRepositoryInterface::class),
                resolve(ContentRepositoryInterface::class)
            );
        });

        // content
        $this->app->singleton(ContentRepositoryInterface::class, function ($app) {
            return new ContentRepository(new Content(),
                resolve(ContentTypeCategoryRepositoryInterface::class)
            );
        });

        // Hadith
        $this->app->singleton(HadithRepositoryInterface::class, function ($app) {
            return new HadithRepository(new HadithContent(),
                resolve(ContentRepositoryInterface::class)
            );
        });

        // Educative
        $this->app->singleton(EducativeRepositoryInterface::class, function ($app) {
            return new EducativeRepository(
                resolve(ContentTypeCategoryRepositoryInterface::class),
                resolve(ContentRepositoryInterface::class)
            );
        });

        // News Portal
        $this->app->singleton(NewsPortalRepositoryInterface::class, function ($app) {
            return new NewsPortalRepository(
                new NewsPortal,
                resolve(ContentRepositoryInterface::class)
            );
        });

        // Quran Repository

        $this->app->singleton(QuranRepositoryInterface::class, function ($app) {
            return new QuranRepository();
        });

        // Rules Interface

        $this->app->singleton(RulesRepositoryInterface::class,function ($app){
            return new RulesRepository(
                new Rules,
                resolve(ContentTypeCategoryRepositoryInterface::class),
                resolve(ContentRepositoryInterface::class),
            );
        });

        $this->app->singleton(PaymentHistoryRepositoryInterface::class,function ($app){
            return new PaymentHistoryRepository(new PaymentHistory());
        });
//        dua
        $this->app->singleton(DuaRepositoryInterface::class,function (){
            return new DuaRepository(new Duas(), new DuasCategory());
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

<?php

namespace App\Console\Commands;

use App\Models\ContentType;
use App\Models\ContentTypeCategory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PreRequisiteData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database-init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'All dependency injection into Database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
       $this->info('Starting Inserting Dependency Data Into Database');

       $user_data = [
           'name' => "admin",
           'email' => "admin@gmail.com",
           'email_verified_at' => Carbon::now()->toDateTimeString(),
           'password' => Hash::make('12345678'),
           'created_at' => Carbon::now()->toDateTimeString()
       ];

        $check_user = DB::table('users')->count();
        if ($check_user == 0) {
            $this->output->progressStart(2);
            for ($i = 0; $i < 2; $i++) {
                sleep(1);
                $this->output->progressAdvance();
            }
            $this->output->progressFinish();
            $this->info('Processing data of users');
            $users = User::insert($user_data);
            if (!$users) {
                $this->error('something went wrong to store users');
            } else {
                $this->info('users data insert successfully');
            }
        }
//        content type
        $content_type_data = [
            [
                'content_type' => 'lifestyle',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'content_type' => 'educative',
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'content_type' => 'rules',
                'created_at' => Carbon::now()->toDateTimeString()
            ]
        ];
        $check_content_type = DB::table('content_types')->count();
        if ($check_content_type == 0) {
            $this->output->progressStart(2);
            for ($i = 0; $i < 2; $i++) {
                sleep(1);
                $this->output->progressAdvance();
            }
            $this->output->progressFinish();
            $this->info('Processing data of content type data');
            $content_type = ContentType::insert($content_type_data);
            if (!$content_type) {
                $this->error('something went wrong to store content type');
            } else {
                $this->info('content type data insert successfully');
            }
        }

//       content category type
        $content_category_data = [
            [
                'category_name' => 'Sports',
                'content_type_id' => 1,
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'category_name' => 'Voeding',
                'content_type_id' => 1,
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'category_name' => 'ramdan-quiz',
                'content_type_id' => 3,
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'category_name' => 'group-quiz',
                'content_type_id' => 3,
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'category_name' => 'cursussen',
                'content_type_id' => 2,
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'category_name' => 'inspiratie',
                'content_type_id' => 2,
                'created_at' => Carbon::now()->toDateTimeString()
            ],
            [
                'category_name' => 'kids',
                'content_type_id' => 2,
                'created_at' => Carbon::now()->toDateTimeString()
            ]
        ];

        $check_category_type = DB::table('content_type_categories')->count();
        if ($check_category_type == 0) {
            $this->output->progressStart(2);
            for ($i = 0; $i < 2; $i++) {
                sleep(1);
                $this->output->progressAdvance();
            }
            $this->output->progressFinish();
            $this->info('Processing data of content category data');
            $content_type = ContentTypeCategory::insert($content_category_data);
            if (!$content_type) {
                $this->error('something went wrong to store content category');
            } else {
                $this->info('content category data insert successfully');
            }
        }

    }
}

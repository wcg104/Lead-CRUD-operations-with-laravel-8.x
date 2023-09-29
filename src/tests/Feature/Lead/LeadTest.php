<?php

namespace Tests\Feature;

use App\Models\Lead;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\CreatesApplication;
use Tests\TestCase;

class LeadTest extends TestCase
{
    use RefreshDatabase; 
    
     // Create lead testing with positive assert
     public function test_create_lead()
     {
         $api = '/lead';
   
         $data = [
             "name" => "test",
             "email" => "jhondoe@test.com",
             "cellphone" => "2553433222",
             "phone_ext" => "+91",
             "phone" => 1425,
             "address1" => "new street",
             "address2" => "NY, US",
             "city" => "Ahmedabad",
             "state" => "Gujarat",
             "country" => "India",
             "password" => "123456",
             "status" => "active"
         ];
         
         $response = $this->post($api, $data);

         $response->assertStatus(200)
            ->assertJson([
                'type' => "success",
            ])->assertJson(fn (AssertableJson $json) => $json->hasAll(['type','code','message','data']));
         
     }     

     // get all leads testing with positive assert
     public function test_get_all_leads()
     {
        $this->test_create_lead();
        $api = '/lead';

        $response = $this->get($api);

        $response->assertStatus(200)
            ->assertJson([
                'type' => "success",
            ])->assertJson(fn (AssertableJson $json) => $json->hasAll(['type','code','message','data']));
     }
 
    //  get lead detail testing with positive assert
     public function test_get_lead_detail()
     {
        
        $this->test_create_lead();
        $leadId = Lead::where('is_deleted',0)->latest()->first()->id;
        $api = "/lead/$leadId";

        $response = $this->get($api);

        $response->assertStatus(200)
        ->assertJson([
            'type' => "success",
        ])->assertJson(fn (AssertableJson $json) => $json->hasAll(['type','code','message','data']));
     }

    //  Update lead testing with positive assert assert
     public function test_update_lead_detail()
     {
        $this->test_create_lead();
        $leadId = Lead::where('is_deleted',0)->latest()->first()->id;
        $api = "/lead/$leadId";

        $data = [
            "name" => "test",
            "email" => "jhon@test.com",
            "cellphone" => "2553433222",
            "phone_ext" => "+91",
            "phone" => 125848687,
            "address1" => "old street",
            "address2" => "NY, US",
            "city" => "Ahmedabad",
            "state" => "Gujarat",
            "country" => "India",
            "password" => "123456",
            "status" => "active"
        ];

        $response = $this->put($api,$data);
        $response->assertStatus(200)
        ->assertJson([
            'type' => "success",
        ])->assertJson(fn (AssertableJson $json) => $json->hasAll(['type','code','message','data']));
     }

    //  Delete lead testing with positive assert
     public function test_lead_delete()
     {
        $this->test_create_lead();
        $leadId = Lead::where('is_deleted',0)->latest()->first()->id;
        $api = "/lead/$leadId";

        $response = $this->delete($api);

        $response->assertStatus(200)
        ->assertJson([
            'type' => "success",
            'message' => "Deleted Successfully"
        ])->assertJson(fn (AssertableJson $json) => $json->hasAll(['type','code','message']));
     }


    // Email format validation testing with negative assert response
     public function test_valid_email_format()
     {
            $api = '/lead';
      
            $data = [
                "name" => "test",
                "email" => "jhon",
                "cellphone" => "2553433222",
                "phone_ext" => "+91",
                "phone" => 1425,
                "address1" => "new street",
                "address2" => "NY, US",
                "city" => "Ahmedabad",
                "state" => "Gujarat",
                "country" => "India",
                "password" => "123456",
                "status" => "active"
            ];

            $response = $this->post($api, $data);
   
            $response->assertStatus(422)
               ->assertJson([
                   'type' => "error",
                   "code" => 422,
                   "message" => "Server Validation Fail",
                   "errors" => ["email" => ["The email must be a valid email address."]]
               ])->assertJson(fn (AssertableJson $json) => $json->hasAll(['type','code','message','errors']));
     }

    //  Email existing value not allowed if user is not deleted testing with negative assert response.
     public function test_email_existing_value_not_allowed_if_user_is_not_deleted()
     {
            
        $this->test_create_lead();

            $api = '/lead';
            $data = [
                "name" => "test",
                "email" => "jhondoe@test.com",
                "cellphone" => "2553433222",
                "phone_ext" => "+91",
                "phone" => 1425,
                "address1" => "new street",
                "address2" => "NY, US",
                "city" => "Ahmedabad",
                "state" => "Gujarat",
                "country" => "India",
                "password" => "123456",
                "status" => "active"
            ];

            $response = $this->post($api, $data);
   
            $response->assertStatus(422)
               ->assertJson([
                   'type' => "error",
                   "code" => 422,
                   "message" => "Server Validation Fail",
                   "errors" => ["email" => ["The email has already been taken."]]
               ])->assertJson(fn (AssertableJson $json) => $json->hasAll(['type','code','message','errors']));
     }

    //  Email existing value allowed if user is deleted testing with positive assert response
     public function test_email_existing_value_allowed_if_user_is_deleted()
     {
        $this->test_lead_delete();
            
        $this->test_create_lead();
     }

    //  Required field validation testing with negative assert response
     public function test_required_field_validation()
     {
        $api = '/lead';
        $data = [
            "name" => "",
            "email" => "",
            "phone" => "",
            "address1" => "",
            "password" => "",
            "status" => ""
        ];

        $errors =  ["name" => ["The name field is required."],
        "password" => ["The password field is required."],
        "phone" => ["The phone field is required."],
        "address1" => ["The address1 field is required."],
        "status" => ["The status field is required."]];


        $response = $this->post($api, $data);
        $response->assertStatus(422)
           ->assertJson([
               'type' => "error",
               "code" => 422,
               "message" => "Server Validation Fail",
               "errors" =>  $errors
           ])->assertJson(fn (AssertableJson $json) => $json->hasAll(['type','code','message','errors']));
           
           
           $this->test_create_lead();
           $leadId = Lead::where('is_deleted',0)->latest()->first()->id;
           $apiUpdate = "/lead/$leadId";

           $responseUpdate = $this->put($apiUpdate, $data);
           $responseUpdate->assertStatus(422)
           ->assertJson([
               'type' => "error",
               "code" => 422,
               "message" => "Server Validation Fail",
               "errors" =>  $errors
           ])->assertJson(fn (AssertableJson $json) => $json->hasAll(['type','code','message','errors']));
           
     }

    //  Column value max limit testing with negative assert
     public function test_validation_for_value_less_than_limit()
     {
        $api = '/lead';
        $data = [
            "name" => "testestttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttt",
            "email" => "testttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttt@test.com",
            "cellphone" => "1234567897894561233215648",
            "phone_ext" => "123445555",
            "phone" => 1234586758942635846,
            "address1" => "testttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttt",
            "address2" => "testtttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttt",
            "city" => "testtttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttyyyyyyyy",
            "state" => "testtttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttyyyyyyyy",
            "country" => "testtttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttyyyyyyyy",
            "password" => "testtttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttdfgggggggggggggggggggggggggggggggggggggggggggggggggggggggtttttttttttttttt",
            "status" => "active"
        ];

        $errors =["name" => ["The name must not be greater than 50 characters."],
                            "password" => ["The password must not be greater than 50 characters."],
                            "cellphone" => ["The cellphone must not be greater than 15 characters."],
                            "phone_ext" => ["The phone ext must not be greater than 5 characters."],                            
                            "address1" => ["The address1 must not be greater than 250 characters."],
                            "address2" => ["The address2 must not be greater than 250 characters."],
                            "city" => ["The city must not be greater than 150 characters."],
                            "state" => ["The state must not be greater than 150 characters."],
                            "country" => ["The country must not be greater than 150 characters."],
                            "email" => ["The email must not be greater than 150 characters."],
                            "phone" => ["The phone must not be greater than 15 characters."]];
        $response = $this->post($api, $data);
        $response->assertStatus(422)
           ->assertJson([
               'type' => "error",
               "code" => 422,
               "message" => "Server Validation Fail",
               "errors" => $errors
           ])->assertJson(fn (AssertableJson $json) => $json->hasAll(['type','code','message','errors']));


           $this->test_create_lead();
           $leadId = Lead::where('is_deleted',0)->latest()->first()->id;
           $apiUpdate = "/lead/$leadId";

           $responseUpdate = $this->put($apiUpdate, $data);
           $responseUpdate->assertStatus(422)
           ->assertJson([
               'type' => "error",
               "code" => 422,
               "message" => "Server Validation Fail",
               "errors" =>  $errors
           ])->assertJson(fn (AssertableJson $json) => $json->hasAll(['type','code','message','errors']));
     }

      //  Column test validation for status value with negative assert
     public function test_validation_for_status_value()
     {
        $api = '/lead';
      
        $data = [
            "name" => "test",
            "email" => "jhondoe@test.com",
            "cellphone" => "2553433222",
            "phone_ext" => "+91",
            "phone" => 1425,
            "address1" => "new street",
            "address2" => "NY, US",
            "city" => "Ahmedabad",
            "state" => "Gujarat",
            "country" => "India",
            "password" => "123456",
            "status" => "unauthorize"
        ];
        $errors = ["status" => ["The selected status is invalid."]];
        $response = $this->post($api, $data);

        $response->assertStatus(422)
           ->assertJson([
               'type' => "error",
               "code" => 422,
               "message" => "Server Validation Fail",
               "errors" => $errors
           ])->assertJson(fn (AssertableJson $json) => $json->hasAll(['type','code','message','errors']));



           $this->test_create_lead();
           $leadId = Lead::where('is_deleted',0)->latest()->first()->id;
           $apiUpdate = "/lead/$leadId";

           $responseUpdate = $this->put($apiUpdate, $data);
           $responseUpdate->assertStatus(422)
           ->assertJson([
               'type' => "error",
               "code" => 422,
               "message" => "Server Validation Fail",
               "errors" =>  $errors
           ])->assertJson(fn (AssertableJson $json) => $json->hasAll(['type','code','message','errors']));
     }

    // Lead update with wrong id testing with negative assert
     public function test_update_lead_detail_with_wrong_id()
     {
        $this->test_create_lead();
        $api = "/lead/1234";

        $data = [
            "name" => "test",
            "email" => "jhondoee@test.com",
            "cellphone" => "2553433222",
            "phone_ext" => "+91",
            "phone" => 125848687,
            "address1" => "old street",
            "address2" => "NY, US",
            "city" => "Ahmedabad",
            "state" => "Gujarat",
            "country" => "India",
            "password" => "123456",
            "status" => "active"
        ];

        $response = $this->put($api,$data);
        $response->assertStatus(404);
     }

      // Lead delete with wrong id testing with negative assert
     public function test_lead_delete_with_wrong_id()
     {
        $this->test_create_lead();
        $api = "/lead/123";

        $response = $this->delete($api);

        $response->assertStatus(404);
     }

      // Get lead detail with wrong id testing with negative assert
     public function test_get_lead_detail_with_wrong_id()
     {        
        $this->test_create_lead();
        $api = "/lead/123";

        $response = $this->get($api);

        $response->assertStatus(404);
     }

 }

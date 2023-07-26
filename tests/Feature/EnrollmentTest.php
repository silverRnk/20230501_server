<?php

namespace Tests\Feature;

use App\Models\Enrollee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EnrollmentTest extends TestCase
{
    protected $baseFilePath = 'public/enrollee_credentials/';
    protected $baseURL = 'api/v1/';
    protected $enrollmentURL = 'api/v1/enroll';

    /**
     * convert Enrollment Form Array to Enrollee Array
     * @param array<string, string>
     * @return array<string, string>
     */
    protected function convertToEnrollees($array): array
    {
        return [
            'name' => $array['first_name'] . ' ' . $array['last_name'],
            'date_of_birth' => $array['date_of_birth'],
            'gender' => $array['gender'],
            'address' => $array['address'],
            'place_of_birth' => $array['place_of_birth'],
            'prev_school' => $array['prev_school']? $array['prev_school']:null,
            'email' => $array['email'],
            'grade_level_id' => $array['grade_level_id'],
            'fathers_name' => $array['fathers_name'],
            'fathers_occupation' => $array['fathers_occupation'],
            'mothers_name' => $array['mothers_name'],
            'mothers_occupation' => $array['mothers_occupation'],
            'guardians_phone_no' => $array['guardians_phone_no'],
            'guardians_email' => $array['guardians_email'],
        ];
    }

    /**
     * A basic feature test example.
     */
    public function test_newEnrollee_res(): void
    {
        Storage::fake('credentials');

        $gender = 'male';

        $data = [
            'first_name' => fake()->firstName($gender),
            'last_name' => fake()->lastName(),
            'date_of_birth' => fake()->date(),
            'gender' => $gender,
            'address' => fake()->address(),
            'place_of_birth' => fake()->city(),
            'enrollee_type' => 'new',
            'prev_school' => null,
            'phone_no' => fake()->phoneNumber(),
            'email' => fake()->freeEmail(),
            'password' => 'changeme',
            'password_confirmation' => 'changeme',
            'grade_level_id' => 0,
            'fathers_name' => fake()->name('male'),
            'fathers_occupation' => 'CEO',
            'mothers_name' => fake()->name('female'),
            'mothers_occupation' => 'CCE',
            'guardians_phone_no' => fake()->phoneNumber(),
            'guardians_email' => fake()->freeEmail(),
            'good_moral' => null,
            'form_138' => null,
            'birth_cert' => UploadedFile::fake()->create('test_birth_cert.pdf', 1, 'application/pdf'),
        ];

        $response = $this->postJson($this->enrollmentURL, $data);

        $queueID = $response->json('queueID');

        $this->assertDatabaseHas('enrollees', $this->convertToEnrollees($data));

        //Assert Birth Cert Exist
        Storage::assertExists($this->baseFilePath. $queueID . '/'.$queueID.'_birth_cert.pdf');

        //Assert Form138 good moral doesn't exist
        Storage::assertMissing([
            $this->baseFilePath.'/'.$queueID.'/'.$queueID.'_form_138.pdf',
            $this->baseFilePath.'/'.$queueID.'/'.$queueID.'_good_moral.pdf'
        ]);

        //Assert Successful res
        $response->assertStatus(201);
    }


    public function test_transfereeEnrollee_w_o_prevSchool_res_error()
    {
        Storage::fake('credentials');

        $gender = 'female';

        $data = [
            'first_name' => fake()->firstName($gender),
            'last_name' => fake()->lastName(),
            'date_of_birth' => fake()->date(),
            'gender' => $gender,
            'address' => fake()->address(),
            'place_of_birth' => fake()->city(),
            'enrollee_type' => 'transferee',
            'prev_school' => '',
            'phone_no' => fake()->phoneNumber(),
            'email' => fake()->freeEmail(),
            'password' => 'changeme',
            'password_confirmation' => 'changeme',
            'grade_level_id' => 2,
            'fathers_name' => fake()->name('male'),
            'fathers_occupation' => 'CEO',
            'mothers_name' => fake()->name('female'),
            'mothers_occupation' => 'CCE',
            'guardians_phone_no' => fake()->phoneNumber(),
            'guardians_email' => fake()->freeEmail(),
            'good_moral' => UploadedFile::fake()->create('test_good_moral12.pdf', 1, 'application/pdf'),
            'form_138' => UploadedFile::fake()->create('test_form_138_12.pdf', 1, 'application/pdf'),
            'birth_cert' => UploadedFile::fake()->create('test_birth_cert12.pdf', 1, 'application/pdf'),
        ];

        $response = $this->postJson($this->enrollmentURL, $data);

        Storage::assertMissing('public/enrollee_credential/*/test_good_moral12.pdf');
        Storage::assertMissing('public/enrollee_credential/*/test_form_138_12.pdf');
        Storage::assertMissing('public/enrollee_credential/*/test_birth_cert12.pdf');

        $this->assertDatabaseMissing('enrollees', $this->convertToEnrollees($data));

    }

    public function test_transfereeEnrollee_w_prevSchool_res_successful()
    {
        // Storage::fake('credentials');

        $gender = 'female';

        $data = [
            'first_name' => fake()->firstName($gender),
            'last_name' => fake()->lastName(),
            'date_of_birth' => fake()->date(),
            'gender' => $gender,
            'address' => fake()->address(),
            'place_of_birth' => fake()->city(),
            'enrollee_type' => 'transferee',
            'prev_school' => 'my_school',
            'phone_no' => fake()->phoneNumber(),
            'email' => fake()->freeEmail(),
            'password' => 'changeme',
            'password_confirmation' => 'changeme',
            'grade_level_id' => 2,
            'fathers_name' => fake()->name('male'),
            'fathers_occupation' => 'CEO',
            'mothers_name' => fake()->name('female'),
            'mothers_occupation' => 'CCE',
            'guardians_phone_no' => fake()->phoneNumber(),
            'guardians_email' => fake()->freeEmail(),
            'good_moral' => UploadedFile::fake()->create('test_good_moral.pdf', 1, 'application/pdf'),
            'form_138' => UploadedFile::fake()->create('test_form_138.pdf', 1, 'application/pdf'),
            'birth_cert' => UploadedFile::fake()->create('test_birth_cert.pdf', 1, 'application/pdf'),
        ];

        $response = $this->postJson($this->enrollmentURL, $data);

        $queueID = $response->json('queueID');
        //Add a new row to enrollees table
        $this->assertDatabaseHas('enrollees', $this->convertToEnrollees($data));

        //assert good moral, form138 and birth cert exist
        Storage::assertExists([
            $this->baseFilePath.'/'.$queueID.'/'.$queueID.'_good_moral.pdf',
            $this->baseFilePath.'/'.$queueID.'/'.$queueID.'_form_138.pdf', 
            $this->baseFilePath.'/'.$queueID.'/'.$queueID.'_birth_cert.pdf']);
        
        //assert successful response
        $response->assertStatus(201);

    }

    public function test_old_enrollee()
    {

        // Storage::fake('storage');

        $gender = 'female';

        $data = [
            'first_name' => fake()->firstName($gender),
            'last_name' => fake()->lastName(),
            'date_of_birth' => fake()->date(),
            'gender' => $gender,
            'address' => fake()->address(),
            'place_of_birth' => fake()->city(),
            'enrollee_type' => 'old',
            'prev_school' => '',
            'phone_no' => fake()->phoneNumber(),
            'email' => fake()->freeEmail(),
            'password' => 'changeme',
            'password_confirmation' => 'changeme',
            'grade_level_id' => 2,
            'fathers_name' => fake()->name('male'),
            'fathers_occupation' => 'CEO',
            'mothers_name' => fake()->name('female'),
            'mothers_occupation' => 'CCE',
            'guardians_phone_no' => fake()->phoneNumber(),
            'guardians_email' => fake()->freeEmail(),
            'good_moral' => null,
            'form_138' => null,
            'birth_cert' => UploadedFile::fake()->create('test_birth_cert.pdf', 1, 'application/pdf'),
        ];

        $response = $this->postJson($this->enrollmentURL, $data);

        $queueID = $response->json('queueID');
        
        //Assert Exist in database
        $this->assertDatabaseHas('enrollees', $this->convertToEnrollees($data));

        
        //Assert birth cert exist
        Storage::assertExists($this->baseFilePath.'/'.$queueID.'/'.$queueID.'_birth_cert.pdf');

        //Assert good moral and form 138 doesn't exist
        Storage::assertMissing([
        $this->baseFilePath.'/'.$queueID.'/'.$queueID.'_good_moral.pdf',
        $this->baseFilePath.'/'.$queueID.'/'.$queueID.'_form_138.pdf',   
        ]);

        //Assert successful response
        $response->assertStatus(201);

    }


    // public function test_enrollee_verification()
    // {

    //     $gender = 'female';

    //     $data = [
    //         'name' => fake()->name($gender),
    //         'date_of_birth' => fake()->date(),
    //         'gender' => $gender,
    //         'address' => fake()->address(),
    //         'place_of_birth' => fake()->city(),
    //         'enrollee_type' => '3',
    //         'prev_school' => '',
    //         'email' => fake()->freeEmail(),
    //         'phone_no' => fake()->phoneNumber(),
    //         'password' => 'changeme',
    //         'grade_level_id' => 'changeme',
    //         'fathers_name' => fake()->name('male'),
    //         'fathers_occupation' => 'CEO',
    //         'mothers_name' => fake()->name('female'),
    //         'mothers_occupation' => 'CCE',
    //         'guardians_phone_no' => fake()->phoneNumber(),
    //         'guardians_email' => fake()->freeEmail(),
    //         'good_moral' => null,
    //         'form_138' => null,
    //         'birth_cert' => null,
    //     ];

    //     $enrollee = Enrollee::create($this->convertToEnrollees($data));

    //     $response = $this
    //     ->withSession(['banned' => false])
    //     ->get($this->baseURL . '/registrar/verified_enrollee' . $enrollee);
    // }
}
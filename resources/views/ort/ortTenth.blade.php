}',
            realm: '{{ $realm }}',
            appName: '{{ $appName }}',
            scopeSeparator: '{{ $scopeSeparator }}',
            additionalQueryStringParams: {{ $additionalQueryStringParams }},
            useBasicAuthenticationWithAccessCodeGrant: {{ $useBasicAuthenticationWithAccessCodeGrant }},
        });
        @endif

        window.ui = ui;
    }
</script>
</body>

</html>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  <?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/index', function () {
    return view('index');
});


Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/user', 'HomeController@user');

Route::get('/adduser', 'HomeController@adduser');

Route::get('/useredit/{id}', 'HomeController@edituser');

Route::get('/userdelete/{id}', 'HomeController@userdelete');

Route::post('/registeruser', 'HomeController@registeruser');

Route::post('/updateuser', 'HomeController@updateuser');

Route::get('/newPatient', 'PatientController@newPatient');

Route::get('/allPatient', 'PatientController@allPatient');

Route::get('/patientEdit/{id}', 'PatientController@patientEdit');

Route::get('/patientprint/{id}', 'PatientController@patientprint');

Route::post('/addPatient', 'PatientController@addPatient');

Route::post('/editPatient', 'PatientController@editPatient');

Route::get('/addPae', 'PaeController@addPae');

Route::get('/paeFirst', 'PaeController@paeFirst');

Route::get('/paeSecond', 'PaeController@paeSecond');

Route::post('/paeSearch', 'PaeController@paeSearch');

Route::post('/paePage1', 'PaeController@paePage1');

Route::post('/paePage2', 'PaeController@paePage2');

Route::post('/paePage3', 'PaeController@paePage3');

Route::post('/paePage4', 'PaeController@paePage4');

Route::post('/paePage5', 'PaeController@paePage5');

Route::post('/paePage6', 'PaeController@paePage6');

Route::post('/paePage7', 'PaeController@paePage7');

Route::post('/paePage8', 'PaeController@paePage8');

Route::post('/paePage9', 'PaeController@paePage9');

Route::post('/paePage10', 'PaeController@paePage10');

Route::get('/paeThird', 'PaeController@paeThird');

Route::get('/paeForth', 'PaeController@paeForth');

Route::get('/paeFive', 'PaeController@paeFive');

Route::get('/paeSixth', 'PaeController@paeSixth');

Route::get('/paeSeven', 'PaeController@paeSeven');

Route::get('/paeEight', 'PaeController@paeEight');

Route::get('/paeNinth', 'PaeController@paeNinth');

Route::get('/paeTenth', 'PaeController@paeTenth');

Route::get('/paePrint', 'PaeController@paePrint');

Route::get('/addNeu', 'NeuController@start');

Route::get('/neuFirst', 'NeuController@neuFirst');

Route::get('/neuSecond', 'NeuController@neuSecond');

Route::get('/neuThird', 'NeuController@neuThird');

Route::get('/neuForth', 'NeuController@neuForth');

Route::get('/neuFifth', 'NeuController@neuFifth');

Route::get('/neuPrint', 'NeuController@neuPrint');

Route::post('/neuSearch', 'NeuController@neuSearch');

Route::post('/neuPage1', 'NeuController@neuPage1');

Route::post('/neuPage2', 'NeuController@neuPage2');

Route::post('/neuPage3', 'NeuController@neuPage3');

Route::post('/neuPage', 'NeuController@neuPage3');

Route::post('/neuPage4', 'NeuController@neuPage4');

Route::post('/neuPage5', 'NeuController@neuPage5');

Route::get('/addOccp', 'OccpController@start');

Route::get('/occFirst', 'OccpController@occFirst');

Route::get('/occSecond', 'OccpController@occSecond');

Route::get('/occThird', 'OccpController@occThird');

Route::get('/occForth', 'OccpController@occForth');

Route::get('/occFifth', 'OccpController@occFifth');

Route::get('/occSixth', 'OccpController@occSixth');

Route::get('/occSeven', 'OccpController@occSeven');

Route::get('/occPrint', 'OccpController@occPrint');

Route::post('/occpSearch', 'OccpController@occpSearch');

Route::post('/occPage1', 'OccpController@occPage1');

Route::post('/occPage2', 'OccpController@occPage2');

Route::post('/occPage3', 'OccpController@occPage3');

Route::post('/occPage4', 'OccpController@occPage4');

Route::post('/occPage5', 'OccpController@occPage5');

Route::post('/occPage6', 'OccpController@occPage6');

Route::post('/occPage7', 'OccpController@occPage7');

Route::get('/addMental', 'MentalController@start');

Route::get('/menFirst', 'MentalController@menFirst');

Route::get('/menSecond', 'MentalController@menSecond');

Route::get('/menThird', 'MentalController@menThird');

Route::get('/menForth', 'MentalController@menForth');

Route::get('/menFifth', 'MentalController@menFifth');

Route::get('/menSixth', 'MentalController@menSixth');

Route::get('/menSeven', 'MentalController@menSeven');

Route::get('/menEight', 'MentalController@menEight');

Route::get('/menPrint', 'MentalController@menPrint');

Route::post('/mentalSearch', 'MentalController@mentalSearch');

Route::post('/menPage1', 'MentalController@menPage1');

Route::post('/menPage2', 'MentalController@menPage2');

Route::post('/menlast', 'MentalController@menlast');

Route::get('/addFit', 'FitController@start');

Route::get('/fitFirst', 'FitController@fitFirst');

Route::get('/fitSecond', 'FitController@fitSecond');

Route::get('/fitPrint', 'FitController@fitPrint');

Route::post('/fitSearch', 'FitController@fitSearch');

Route::post('/fitPage1', 'FitController@fitPage1');

Route::post('/fitPage2', 'FitController@fitPage2');

Route::get('/addOrt', 'OrtController@start');

Route::get('/ortFirst', 'OrtController@ortFirst');

Route::get('/ortSecond', 'OrtController@ortSecond');

Route::get('/ortThird', 'OrtController@ortThird');

Route::get('/ortForth', 'OrtController@ortForth');

Route::get('/ortFifth', 'OrtController@ortFifth');

Route::get('/ortSixth', 'OrtController@ortSixth');

Route::get('/ortSeventh', 'OrtController@ortSeventh');

Route::get('/ortEight', 'OrtController@ortEight');

Route::get('/ortNine', 'OrtController@ortNine');

Route::get('/ortTenth', 'OrtController@ortTenth');

Route::get('/ortEleven', 'OrtController@ortEleven');

Route::get('/ortTwelve', 'OrtController@ortTwelve');

Route::get('/ortThirteen', 'OrtController@ortThirteen');

Route::get('/ortPrint', 'OrtController@ortPrint');

Route::post('/ortSearch', 'OrtController@ortSearch');

Route::post('/ortPage1', 'OrtController@ortPage1');

Route::post('/ortPage2', 'OrtController@ortPage2');

Route::post('/ortPage3', 'OrtController@ortPage3');

Route::post('/ortPage4', 'OrtController@ortPage4');

Route::post('/ortPage5', 'OrtController@ortPage5');

Route::post('/ortPage6', 'OrtController@ortPage6');

Route::post('/ortPage7', 'OrtController@ortPage7');

Route::post('/ortPage8', 'OrtController@ortPage8');

Route::post('/ortPage9', 'OrtController@ortPage9');

Route::post('/ortPage10', 'OrtController@ortPage10');

Route::post('/ortPage11', 'OrtController@ortPage11');

Route::post('/ortPage
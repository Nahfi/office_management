<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminMeetingReportController;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\Admin\AdminProjectTestingReportController;
use App\Http\Controllers\Admin\AllUserController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\ConfigSettingsController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Employee\EmployeeHomeController;
use App\Http\Controllers\Employee\EmployeeProfileController;
use App\Http\Controllers\Admin\ExpenseCategoryController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\GeneralSettingsController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Employee\Auth\EmployeeForgotPasswordController;
use App\Http\Controllers\Employee\Auth\EmployeeLoginController;
use App\Http\Controllers\Employee\Auth\EmployeeResetPasswordController;
use App\Http\Controllers\Employee\EmployeeWorkReportController;
use App\Http\Controllers\Employee\EmployeeMeetingReportController;
use App\Http\Controllers\Admin\AdminWorkReportController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\EmailController;
use App\Http\Controllers\Admin\EmployeeAttendanceController;
use App\Http\Controllers\Admin\HolidayController;
use App\Http\Controllers\Admin\WorkingDayController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\LeaveController;
use App\Http\Controllers\Admin\LeaveRequestController;
use App\Http\Controllers\Admin\SalaryController;
use App\Http\Controllers\Employee\AttendanceController;
use App\Http\Controllers\Employee\EmployeeLeaveController;
use App\Http\Controllers\Employee\EmployeeLeaveRequestController;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\WorkOrderController;
use  App\Http\Controllers\Customer\CustomerProjectController;
use App\Http\Controllers\Admin\IncomeController;
use App\Http\Controllers\Customer\CustomerInvoiceController;
use App\Http\Controllers\Employee\EmployeeProjectTestingReportController;
use App\Http\Controllers\Customer\CustomerProfileController;
use App\Http\Controllers\Employee\EmployeeSalaryController;
use App\Http\Controllers\Employee\EmployeeEmailController;
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
    if(Auth::guard('admin')->check()){
        return redirect()->route('admin.home');
    }
    elseif(Auth::guard('employee')->check()){
        return redirect()->route('employee.home');
    }
    elseif(Auth::guard('web')->check()){
        return redirect()->route('customer.home');
    }
    return view('welcome');
});

Auth::routes(['verify' => true]);

/**
 * Frontend route start
 */

 Route::as('customer.')->group(function(){
    /**
     * Guest route with web guard start
     */

     /**
      * Guest route with web guard end
      */

      /**
       * Authenticate with web guard start
       */
        Route::middleware(['auth:web','verified','checkStatus'])->prefix('customer')->group(function(){
            //customer home route
           Route::controller(DashboardController::class)->group(function(){
                Route::get('/dashboard','index')->name('home');
           });

            //customer profile route
            Route::controller(CustomerProfileController::class)->prefix('profile')->as('profile.')->group(function(){
                Route::get('/','index')->name('index');
                Route::post('/update','update')->name('update');
                Route::post('/update-password','updatePassword')->name('password.update');

            });

           //project route
           Route::controller(CustomerProjectController::class)->prefix('project')->name('project.')->group(function(){
            Route::get('/index','index')->name('index');
            Route::get('/show/{id}','show')->name('show');
            Route::get('/show-details/{id}','showDetails')->name('showDetails');
           });

             //invoice route
             Route::controller(CustomerInvoiceController::class)->prefix('invoice')->as('invoice.')->group(function(){
                Route::get('/index','index')->name('index');
                Route::get('/invoice-show/{id}','show')->name('invoice-show');
                Route::get('/invoice-show-pos/{id}','showPos')->name('invoiceShowPos');
            });

        });
      /**
       * Authenticate with web guard end
       */
 });
 /**
  * Fronend route end
  */
/**
 * admin  route start
 */
    Route::prefix('admin')->as('admin.')->group(function(){

        /**
         * guest route with admin guard start
         */

        Route::middleware('guest:admin')->group(function(){

            //login controller
            Route::controller(LoginController::class)->group(function(){
                Route::get('/login','showLoginForm')->name('login');
                Route::post('/login/post','login')->name('login.post');
            });

            //forgetpassword controller
            Route::controller(ForgotPasswordController::class)->group(function(){
                Route::get('/reset-password','showLinkRequestForm')->name('resetPassword');
                Route::post('/reset-password/post','sendResetLinkEmail')->name('resetpassword.post');
            });

            //reset password controller
            Route::controller(ResetPasswordController::class)->group(function(){
                Route::get('/update-password/{token}','index')->name('updatePassword');
                Route::post('/update-password','update')->name('updatePassword.post');
            });

        });

        /**
         * guest route with admin guard end
         */


         /**
          * Authenticated with admin guard route start
          */
            Route::middleware(['auth:admin','checkStatus'])->group(function(){

                //logout
                Route::controller(LoginController::class)->group(function(){
                    Route::post('/logout','logout')->name('logout');
                });

                //home route
                Route::controller(HomeController::class)->group(function(){
                    Route::get('/dashboard','index')->name('home');
                });

                //roles route
                Route::controller(RolesController::class)->prefix('roles')->as('roles.')->group(function(){
                    Route::get('/index','index')->name('index');
                    Route::get('/create','create')->name('create');
                    Route::post('/store','store')->name('store');
                    Route::get('/edit/{id}','edit')->name('edit');
                    Route::post('/update/{id}','update')->name('update');
                    Route::get('/destroy/{id}','destroy')->name('destroy');

                });

                //admin route
                Route::controller(AdminController::class)->as('admin.')->group(function(){
                    Route::get('/index','index')->name('index');
                    Route::get('/create','create')->name('create');
                    Route::post('/store','store')->name('store');
                    Route::get('/edit/{id}','edit')->name('edit');
                    Route::post('/update/{id}','update')->name('update');
                    Route::get('/destroy/{id}','destroy')->name('destroy');
                });

                //profile route
                Route::controller(ProfileController::class)->prefix('profile')->as('profile.')->group(function(){
                    Route::get('/','index')->name('index');
                    Route::post('/update','update')->name('update');
                    Route::post('/update-password','updatePassword')->name('password.update');

                });

                //settings route
                Route::prefix('settings')->as('settings.')->group(function(){
                    Route::controller(GeneralSettingsController::class)->group(function(){
                        Route::get('/general','generalSettings')->name('general');
                        Route::post('/general/post/{id}','generalSettingsUpdate')->name('general.post');
                    });
                    Route::controller(ConfigSettingsController::class)->group(function(){
                        Route::get('/config','configSettings')->name('config');
                        Route::get('/config-optimize-clear','optimizeClear')->name('config.optimize.clear');
                        Route::get('/config-optimize','optimize')->name('config.optimize');
                    });
                });


                //attendacne route
                Route::controller(EmployeeAttendanceController::class)->prefix('attendance')->as('attendance.')->group(function(){
                    Route::get('/list','index')->name('index');
                    Route::post('status-update/{id}','statusUpdate')->name('statusUpdate');
                });
                //expense  route
                Route::prefix('expense')->as('expense.')->group(function(){
                    //expense category route
                    Route::controller(ExpenseCategoryController::class)->prefix('category')->as('category.')->group(function(){
                        Route::get('/index','index')->name('index');
                        Route::get('/create','create')->name('create');
                        Route::post('/store','store')->name('store');
                        Route::get('/edit/{id}','edit')->name('edit');
                        Route::post('/update/{id}','update')->name('update');
                        Route::get('/destroy/{id}','destroy')->name('destroy');
                        Route::get('/restore/{id}','restore')->name('restore');
                        Route::get('/parmanent-delete/{id}','parmanentDelete')->name('parmanentDelete');

                        Route::get('/active','showActiveCategory')->name('active');
                        Route::get('/deactive','showDeActiveCategory')->name('deactive');
                        Route::get('/trash','showDeletedCategory')->name('trash');
                        Route::post('/mark','mark')->name('mark');
                    });
                    //expense route
                    Route::controller(ExpenseController::class)->group(function(){
                        Route::get('/index','index')->name('index');
                        Route::get('/create','create')->name('create');
                        Route::post('/store','store')->name('store');
                        Route::get('/edit/{id}','edit')->name('edit');
                        Route::post('/update/{id}','update')->name('update');
                        Route::get('/destroy/{id}','destroy')->name('destroy');
                        Route::get('/restore/{id}','restore')->name('restore');
                        Route::get('/parmanent-delete/{id}','parmanentDelete')->name('parmanentDelete');

                        Route::get('/active','showActiveExpense')->name('active');
                        Route::get('/deactive','showDeActiveExpense')->name('deactive');
                        Route::get('/trash','showDeletedExpense')->name('trash');

                        Route::post('/mark','mark')->name('mark');
                    });
                });

                //working day route
                Route::controller(WorkingDayController::class)->prefix('working-day')->as('workingDay.')->group(function(){
                    Route::get('/index','index')->name('index');
                    Route::get('/create','create')->name('create');
                    Route::post('/store','store')->name('store');
                    Route::get('/edit/{id}','edit')->name('edit');
                    Route::post('/update/{id}','update')->name('update');
                    Route::get('/destroy/{id}','destroy')->name('destroy');
                });
                //employee leave route
                Route::controller(LeaveController::class)->prefix('employee-leave')->as('employeeLeave.')->group(function(){
                    Route::get('/index','index')->name('index');
                    Route::get('/create','create')->name('create');
                    Route::post('/store','store')->name('store');
                    Route::get('/edit/{id}','edit')->name('edit');
                    Route::post('/update/{id}','update')->name('update');
                    Route::get('/destroy/{id}','destroy')->name('destroy');

                    Route::get('/show-details/{id}','showDetails')->name('showDetails');
                    Route::post('/store-details/{id}','storeDetails')->name('storeDetails');
                    Route::post('/update-details/{id}','updateDetails')->name('updateDetails');
                    Route::get('/delete-details/{id}','destroyDetails')->name('destroyDetails');

                });


                //leave reqeust controller
                Route::controller(LeaveRequestController::class)->prefix('leave-request')->as('leaveRequest.')->group(function(){
                    Route::get('index','index')->name('index');
                    Route::post('/status-update/{id}','statusUpdate')->name('statusUpdate');
                    Route::get('/show-details/{id}','show')->name('show');
                });

                //hoilday route
                Route::controller(HolidayController::class)->prefix('holiday')->as('holiday.')->group(function(){
                    Route::get('/index','index')->name('index');
                    Route::get('/create','create')->name('create');
                    Route::post('/store','store')->name('store');
                    Route::get('/edit/{id}','edit')->name('edit');
                    Route::post('/update/{id}','update')->name('update');
                    Route::get('/destroy/{id}','destroy')->name('destroy');

                    //holiday details
                    Route::get('/show-details/{id}','showDetails')->name('showDetails');
                    Route::post('/store-details/{id}','storeDetails')->name('storeDetails');
                    Route::post('/update-details/{id}','updateDetails')->name('updateDetails');
                    Route::get('/destroy-details/{id}','destroyDetails')->name('destroyDetails');
                });

                //employee route
                Route::controller(EmployeeController::class)->prefix('employee')->as('employee.')->group(function(){
                    Route::get('/index','index')->name('index');
                    Route::get('/create','create')->name('create');
                    Route::post('/store','store')->name('store');
                    Route::get('/show/{id}','show')->name('show');
                    Route::get('/edit/{id}','edit')->name('edit');
                    Route::post('/update/{id}','update')->name('update');
                    Route::get('/destroy/{id}','destroy')->name('destroy');
                    Route::get('/restore/{id}','restore')->name('restore');
                    Route::get('/trash','trashEmployee')->name('trash');
                    Route::get('/parmanent-delete/{id}','parmanentDelete')->name('parmanenetDelete');
                });

                //customer route
                Route::controller(CustomerController::class)->prefix('customer')->as('customer.')->group(function(){
                    Route::get('/index','index')->name('index');
                    Route::get('/create','create')->name('create');
                    Route::post('/store','store')->name('store');
                    Route::get('/show/{id}','show')->name('show');
                    Route::get('/edit/{id}','edit')->name('edit');
                    Route::post('/update/{id}','update')->name('update');
                    Route::get('/destroy/{id}','destroy')->name('destroy');
                    Route::get('/restore/{id}','restore')->name('restore');
                    Route::get('/trash','trashCustomer')->name('trash');
                    Route::get('/parmanent-delete/{id}','parmanentDelete')->name('parmanenetDelete');
                });

               //work report route
               Route::controller(AdminWorkReportController::class)->prefix('work-report')->as('workReport.')->group(function(){
                  Route::get('/index','index')->name('index');
                  Route::get('/show/{id}','show')->name('show');
                  Route::get('/trash','showDeletedWorkReport')->name('trash');
                  Route::get('/edit/{id}','edit')->name('edit');
                  Route::post('/update/{id}','update')->name('update');
                  Route::get('/destroy/{id}','destroy')->name('destroy');
                  Route::get('/restore/{id}','restore')->name('restore');
                  Route::get('/parmanent-delete/{id}','parmanentDelete')->name('parmanenetDelete');
               });

               //meeting report route
               Route::controller(AdminMeetingReportController::class)->prefix('meeting-report')->as('meetingReport.')->group(function(){
                Route::get('/index','index')->name('index');
                Route::get('/show/{id}','show')->name('show');
                Route::get('/trash','showDeletedMeetingReport')->name('trash');
                Route::get('/edit/{id}','edit')->name('edit');
                Route::post('/update/{id}','update')->name('update');
                Route::get('/destroy/{id}','destroy')->name('destroy');
                Route::get('/restore/{id}','restore')->name('restore');
                Route::get('/parmanent-delete/{id}','parmanentDelete')->name('parmanenetDelete');
             });

             //invoice route
              Route::controller(InvoiceController::class)->prefix('invoice')->as('invoice.')->group(function(){
                Route::get('/create','create')->name('create');
                Route::get('/index','index')->name('index');
                Route::post('/store','store')->name('store');
                Route::get('/invoice-show/{id}','show')->name('invoice-show');
                Route::get('/invoice-show-pos/{id}','showPos')->name('invoiceShowPos');
                Route::get('/edit/{id}','edit')->name('edit');
                Route::post('/update/{id}','update')->name('update');
                Route::post('/update-invoice-info/{id}','updateInvoiceInfo')->name('updateInvoiceInfo');
                Route::post('/update-comment/{id}','updateComment')->name('updateComment');
                Route::get('/delete/{id}','delete')->name('delete');
                Route::get('/destroy/{id}','destroy')->name('destroy');
                Route::get('/restore/{id}','restore')->name('restore');
                Route::get('/parmanent-delete/{id}','parmanentDelete')->name('parmanentDelete');
                Route::get('/trash','showDeletedInvoice')->name('trash');
                Route::post('/mark','mark')->name('mark');
                Route::get('/find-specific-customer/{id}','findSpecificCustomer')->name('findSpecificCustomer');

            });

            //email route
            Route::controller(EmailController::class)->prefix('email')->name('email.')->group(function(){
                Route::get('/index','index')->name('index');
                Route::post('/store','store')->name('store');
                Route::get('/show/{id}','show')->name('show');
                Route::get('/show-email/{slug}','showSpecificMail')->name('showSpecificMail');
                Route::get('/unread-email','allUnreadEmail')->name('allUnreadEmail');
                Route::get('/sent-email','allSentEmail')->name('allSentEmail');
                Route::get('/destroy-received-email/{id}','destroyReceivedEmail')->name('destroyReceivedEmail');
                Route::get('/destroy-email/{id}','destroySentEmail')->name('destroySentEmail');
                Route::post('/mark','mark')->name('mark');
                Route::get('/trash','trash')->name('trash');
                Route::get('/restore/{id}','restore')->name('restore');
            });

            //project route
            Route::controller(AdminProjectController::class)->prefix('project')->name('project.')->group(function(){
                Route::get('/index','index')->name('index');
                Route::get('/create','create')->name('create');
                Route::post('/store','store')->name('store');
                Route::get('/show/{id}','show')->name('show');
                Route::get('/show-test-report/{id}','showTestReport')->name('showTestReport');
                Route::get('/edit/{id}','edit')->name('edit');
                Route::post('/update/{id}','update')->name('update');
                Route::get('/delete/{id}','delete')->name('delete');
                Route::get('/download-requirment/{id}','downloadRequirment')->name('downloadRequirment');
                Route::get('/download-deed/{id}','downloadDeed')->name('downloadDeed');
                Route::get('/download-work-order/{id}','downloadWorkOrder')->name('downloadWorkOrder');
            });

         //project testing report  route
           Route::controller(AdminProjectTestingReportController::class)->prefix('project-testing')->name('projectTesting.')->group(function(){
            Route::get('/index','index')->name('index');
            Route::get('/show/{id}','show')->name('show');
            Route::get('/edit/{id}','edit')->name('edit');
            Route::post('/update/{id}','update')->name('update');
        });



            // income route
            Route::controller(IncomeController::class)->prefix('income')->name('income.')->group(function(){
                Route::get('/index','index')->name('index');
            });

            //salary route
            Route::controller(SalaryController::class)->prefix('salary')->as('salary.')->group(function(){
                Route::get('/view','index')->name('index');
                Route::post('/update/{id}','update')->name('update');
                Route::get('/pay-slip/{id}','show')->name('show');
            });


            });
          /**
           * Authenticated with admin guard route end
           */

    });

/**
 * admin  route end
 *
 *
*/

/**
 * Emplopyee route start
 */
Route::prefix('employee')->as('employee.')->group(function(){

    /**
     * guest route with employee guard start
     */

    Route::middleware('guest:employee')->group(function(){

        //login controller
        Route::controller(EmployeeLoginController::class)->group(function(){
            Route::get('/login','showLoginForm')->name('login');
            Route::post('/login/post','login')->name('login.post');
        });

        //forgetpassword controller
        Route::controller(EmployeeForgotPasswordController::class)->group(function(){
            Route::get('/reset-password','showLinkRequestForm')->name('resetPassword');
            Route::post('/reset-password/post','sendResetLinkEmail')->name('resetpassword.post');
        });
        //reset password controller
        Route::controller(EmployeeResetPasswordController::class)->group(function(){
            Route::get('/update-password/{token}','index')->name('updatePassword');
            Route::post('/update-password','update')->name('updatePassword.post');
        });

    });

    /**
     * guest route with employee guard end
     */


     /**
      * Authenticated with employee guard route start
      */
        Route::middleware(['auth:employee','checkStatus'])->group(function(){

            //logout
            Route::controller(EmployeeLoginController::class)->group(function(){
                Route::post('/logout','logout')->name('logout');
            });

            //home route
            Route::controller(EmployeeHomeController::class)->group(function(){
                Route::get('/dashboard','index')->name('home');
            });

            //profile route
            Route::controller(EmployeeProfileController::class)->prefix('profile')->as('profile.')->group(function(){
                Route::get('/','index')->name('index');
                Route::post('/update','update')->name('update');
                Route::post('/update-password','updatePassword')->name('password.update');

            });

            //work reports route
            Route::controller(EmployeeWorkReportController::class)->prefix('work-report')->as('workReport.')->group(function(){
                //report
                Route::get('/index','index')->name('index');
                Route::get('/create','create')->name('create');
                Route::post('/store','store')->name('store');
                Route::get('/edit/{id}','edit')->name('edit');
                Route::post('/update','update')->name('update');
                Route::get('/destroy/{id}','destroy')->name('destroy');
                Route::get('/restore/{id}','restore')->name('restore');
                Route::get('/parmanent-delete/{id}','parmanentDelete')->name('parmanenetDelete');
                //report details
                Route::post('/store-report-details','detailsStore')->name('details.store');
                Route::get('/edit-details/{id}','editDetails')->name('editDetails');
                Route::post('/update-details','updateDetails')->name('updateDetails');
                Route::get('/destroy-details/{id}','destroyDetails')->name('destroyDetails');
                //search by date
                Route::get('/search-by-date','search')->name('search');

            });

            //meeting report route

            Route::controller(EmployeeMeetingReportController::class)->prefix('meeting-report')->as('meetingReport.')->group(function(){
                //report
                Route::get('/index','index')->name('index');
                Route::get('/create','create')->name('create');
                Route::post('/store','store')->name('store');
                Route::get('/edit/{id}','edit')->name('edit');
                Route::post('/update','update')->name('update');
                Route::get('/destroy/{id}','destroy')->name('destroy');
                Route::get('/restore/{id}','restore')->name('restore');
                Route::get('/parmanent-delete/{id}','parmanentDelete')->name('parmanenetDelete');
                //report details
                Route::post('/store-report-details','detailsStore')->name('details.store');
                Route::get('/edit-details/{id}','editDetails')->name('editDetails');
                Route::post('/update-details','updateDetails')->name('updateDetails');
                Route::get('/destroy-details/{id}','destroyDetails')->name('destroyDetails');
                //search by date
                Route::get('/search-by-date','search')->name('search');
            });

            //leave route
            Route::controller(EmployeeLeaveController::class)->prefix('leave')->as('leave.')->group(function(){
                Route::get('/index','index')->name('index');
                Route::get('/show/{id}','show')->name('show');
            });

            //leave request route
            Route::controller(EmployeeLeaveRequestController::class)->prefix('leave-request')->as('leaveRequest.')->group(function(){
                Route::get('/index','index')->name('index');
                Route::get('/show/{id}','show')->name('show');
                Route::get('/create','create')->name('create');
                Route::post('/store','store')->name('store');
                Route::get('/destroy/{id}','destroy')->name('destroy');
            });

            //work order route
            Route::controller(WorkOrderController::class)->prefix('project')->name('workOrder.')->group(function(){
                Route::get('/index','index')->name('index');
                Route::get('/edit/{id}','edit')->name('edit');
                Route::post('/update/{id}','update')->name('update');
                Route::get('/show/{id}','show')->name('show');
                Route::get('/show-details/{id}','showDetails')->name('showDetails');
                Route::get('/show-test-report/{id}','showTestReport')->name('showTestReport');
                Route::get('/destroy/{id}','destroy')->name('destroy');
                Route::get('/download-requirment/{id}','downloadRequirment')->name('downloadRequirment');
            });

            //project test report route
            Route::controller(EmployeeProjectTestingReportController::class)->prefix('project-test-report')->name('testReport.')->group(function(){
                Route::get('/index','index')->name('index');
                Route::get('/create/{id}','create')->name('create');
                Route::post('/store','store')->name('store');
                Route::get('/edit/{id}','edit')->name('edit');
                Route::post('/update/{id}','update')->name('update');
                Route::post('/update-status/{id}','updateStatus')->name('updateStatus');
                Route::get('/show/{id}','show')->name('show');
                Route::get('/show-test-report/{id}','showTestReport')->name('showTestReport');
                Route::get('/destroy/{id}','destroy')->name('destroy');
            });


            //attendance route
            Route::controller(AttendanceController::class)->prefix('attendance')->as('attendance.')->group(function(){
                Route::get('/attendance-list','index')->name('index');
                Route::get('/give-attendance','sendRequest')->name('sendRequest');
            });

            //salary route
            Route::controller(EmployeeSalaryController::class)->prefix('salary')->name('salary.')->group(function(){
                Route::get('/index','index')->name('index');
                Route::get('/pay-slip/{id}','show')->name('show');
            });

         //email route
            Route::controller(EmployeeEmailController::class)->prefix('email')->name('email.')->group(function(){
                Route::get('/index','index')->name('index');
                Route::post('/store','store')->name('store');
                Route::get('/show/{id}','show')->name('show');
                Route::get('/show-email/{slug}','showSpecificMail')->name('showSpecificMail');
                Route::get('/unread-email','allUnreadEmail')->name('allUnreadEmail');
                Route::get('/sent-email','allSentEmail')->name('allSentEmail');
                Route::get('/destroy-received-email/{id}','destroyReceivedEmail')->name('destroyReceivedEmail');
                Route::get('/destroy-email/{id}','destroySentEmail')->name('destroySentEmail');
                Route::post('/mark','mark')->name('mark');
                Route::get('/trash','trash')->name('trash');
                Route::get('/restore/{id}','restore')->name('restore');
            });



        });
      /**
       * Authenticated with employee guard route end
       */

});

 /**
  * Employee route end
  */
Route::fallback(function () {
    return redirect('/');
});
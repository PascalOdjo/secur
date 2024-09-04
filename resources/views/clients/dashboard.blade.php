@extends('layouts.app')

@section('content')
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">CRM</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">CRM</li>
                </ol>
            </div>
        </div>
        <div class="col-md-4 col-lg-4">
            <div class="widgetbar">
                <button class="btn btn-primary"><i class="ri-refresh-line mr-2"></i>Refresh</button>
            </div>                        
        </div>
    </div>
    
    <div class="contentbar">   
        <!-- Start row -->
        <div class="row"> 
            <!-- Start col -->
            <div class="col-lg-12 col-xl-3">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col-8">
                                <p class="font-15">Revenue Increase</p>
                                <h4 class="card-title mb-0">5%</h4>
                            </div>
                            <div class="col-4 text-right">
                                <span class="iconbar iconbar-md bg-primary text-white rounded"><i class="ri-arrow-right-up-line align-unset"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col-8">
                                <p class="font-15">Open Projects</p>
                                <h4 class="card-title mb-0">198</h4>
                            </div>
                            <div class="col-4 text-right">
                                <span class="iconbar iconbar-md bg-primary text-white rounded"><i class="ri-money-dollar-circle-line align-unset"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col-8">
                                <p class="font-15">Working Employees</p>
                                <h4 class="card-title mb-0">15,986</h4>
                            </div>
                            <div class="col-4 text-right">
                                <span class="iconbar iconbar-md bg-primary text-white rounded"><i class="ri-user-3-line align-unset"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->  
            <!-- Start col -->
            <div class="col-lg-12 col-xl-9">
                <div class="card m-b-30">
                    <div class="card-header">                                
                        <div class="row align-items-center">
                            <div class="col-6 col-lg-9">
                                <h5 class="card-title mb-0">Lead Compare</h5>
                            </div>
                            <div class="col-6 col-lg-3">
                                <select class="form-control font-12">
                                    <option value="class1" selected>Last Week</option>
                                    <option value="class2">Last Month</option>
                                    <option value="class3">Last Year</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div id="apex-bar-chart"></div>
                    </div>
                </div>
            </div>
            <!-- End col -->                    
        </div>
        <!-- End row -->
        <!-- Start row -->
        <div class="row"> 
            <!-- Start col -->
            <div class="col-lg-12 col-xl-9">
                <div class="card m-b-30">
                    <div class="card-header">                                
                        <div class="row align-items-center">
                            <div class="col-6 col-lg-9">
                                <h5 class="card-title mb-0">Average Monthly Revenue</h5>
                            </div>
                            <div class="col-6 col-lg-3">
                                <select class="form-control font-12">
                                    <option value="class1" selected>Last Week</option>
                                    <option value="class2">Last Month</option>
                                    <option value="class3">Last Year</option>
                                </select>
                            </div>
                        </div>
                        <h2>$9,86,587</h2>  
                    </div>
                    <div class="card-body p-0">
                        <div id="apex-area-chart"></div>
                    </div>
                </div>
            </div>
            <!-- End col -->  
            <!-- Start col -->
            <div class="col-lg-12 col-xl-3">
                <div class="card m-b-30">
                    <div class="card-header text-center">                                
                        <h5 class="card-title mb-0">Ticket Status</h5>
                    </div>
                    <div class="card-body text-center">
                        <div id="apex-stroked-circle-guage-chart"></div>
                    </div>
                    <div class="card-footer text-center">
                        <div class="row">
                            <div class="col-4 border-right px-0">
                                <p class="my-2">New</p>
                                <h5>589</h5>
                            </div>
                            <div class="col-4 border-right px-0">
                                <p class="my-2">Open</p>
                                <h5>1298</h5>
                            </div>
                            <div class="col-4 px-0">
                                <p class="my-2">Time</p>
                                <h5>1 Day</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->                    
        </div>
        <!-- End row -->
        <!-- Start row -->
        <div class="row"> 
            <!-- Start col -->
            <div class="col-lg-12 col-xl-4">
                <div class="card m-b-30">
                    <div class="card-header">                                
                        <h5 class="card-title mb-0">Projects</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <h4>Project Space EU</h4>
                            <p>Expected Delivery Date<br> 25 Oct, 2020</p>
                        </div>
                        <div class="row align-items-center my-5">
                            <div class="col-7">
                                <h4 class="mb-1">192</h4>
                                <p class="mb-0">Team Strength</p>
                            </div>
                            <div class="col-5 text-right">
                                <div class="avatar-group">
                                    <div class="avatar">
                                        <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="John Doe">
                                            <img src="assets/images/users/men.svg" alt="avatar" class="rounded-circle">
                                        </a>
                                    </div>
                                    <div class="avatar">
                                        <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="John Doe">
                                            <img src="assets/images/users/women.svg" alt="avatar" class="rounded-circle">
                                        </a>
                                    </div>
                                    <div class="avatar">
                                        <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="John Doe">
                                            <img src="assets/images/users/boy.svg" alt="avatar" class="rounded-circle">
                                        </a>
                                    </div>
                                </div>
                            </div>                                    
                        </div>
                        <h5 class="mb-3">75% <span class="float-right font-16 font-weight-normal text-muted">Completed</span></h5>
                        <div class="progress" style="height: 5px;">
                          <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col -->  
            <!-- Start col -->
            <div class="col-lg-12 col-xl-4">
                <div class="card m-b-30">
                    <div class="card-header">                                
                        <div class="row align-items-center">
                            <div class="col-9">
                                <h5 class="card-title mb-0">Project Sector</h5>
                            </div>
                            <div class="col-3">
                                <button type="button" class="btn btn-outline-light text-muted btn-sm float-right font-12">View</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Progress</th>
                                        <th class="text-right">%</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Healthcare</td>
                                        <td>
                                            <div class="progress" style="height: 4px;">
                                              <div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td class="text-right">75%</td>
                                    </tr>
                                    <tr>
                                        <td>Banking Finance</td>
                                        <td>
                                            <div class="progress" style="height: 4px;">
                                              <div class="progress-bar bg-success" role="progressbar" style="width: 40%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td class="text-right">40%</td>
                                    </tr>
                                    <tr>
                                        <td>FMCG</td>
                                        <td>
                                            <div class="progress" style="height: 4px;">
                                              <div class="progress-bar bg-danger" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td class="text-right">60%</td>
                                    </tr>
                                    <tr>
                                        <td>Agriculture</td>
                                        <td>
                                            <div class="progress" style="height: 4px;">
                                              <div class="progress-bar bg-warning" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td class="text-right">50%</td>
                                    </tr>
                                    <tr>
                                        <td>Automobile</td>
                                        <td>
                                            <div class="progress" style="height: 4px;">
                                              <div class="progress-bar bg-info" role="progressbar" style="width: 87%;" aria-valuenow="87" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td class="text-right">87%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End col --> 
            <!-- Start col -->
            <div class="col-lg-12 col-xl-4">
                <div class="card m-b-30">
                    <div class="card-header">                                
                        <div class="row align-items-center">
                            <div class="col-9">
                                <h5 class="card-title mb-0">Activity</h5>
                            </div>
                            <div class="col-3">
                                <button type="button" class="btn btn-outline-light text-muted btn-sm float-right font-12">View</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">                                                    
                            <li class="media mb-4">
                                <span class="iconbar iconbar-md bg-primary text-white rounded align-self-center mr-3"><i class="ri-folder-5-line align-unset"></i></span>
                                <div class="media-body">
                                    <h5 class="mt-0 mb-1 font-16">Project 01 timeline approved</h5>
                                    <p class="mb-0">2 hours ago</p>                            
                                </div>
                            </li>
                            <li class="media mb-4">
                                <span class="iconbar iconbar-md bg-success text-white rounded align-self-center mr-3"><i class="ri-user-3-line align-unset"></i></span>
                                <div class="media-body">
                                    <h5 class="mt-0 mb-1 font-16">Ronnie applied for leave</h5>
                                    <p class="mb-0">10 hours ago</p>                            
                                </div>
                            </li>
                            <li class="media mb-4">
                                <span class="iconbar iconbar-md bg-warning text-white rounded align-self-center mr-3"><i class="ri-calendar-event-line align-unset"></i></span>
                                <div class="media-body">
                                    <h5 class="mt-0 mb-1 font-16">Meeting Schedule with WIPRO</h5>
                                    <p class="mb-0">27 May, 2020</p>                            
                                </div>
                            </li>
                            <li class="media mb-4">
                                <span class="iconbar iconbar-md bg-danger text-white rounded align-self-center mr-3"><i class="ri-eye-2-line align-unset"></i></span>
                                <div class="media-body">
                                    <h5 class="mt-0 mb-1 font-16">Presentation for final tapeout</h5>
                                    <p class="mb-0">15 Mar, 2020</p>                            
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- End col -->                    
        </div>
        <!-- End row -->
    </div>
</div>
@endsection

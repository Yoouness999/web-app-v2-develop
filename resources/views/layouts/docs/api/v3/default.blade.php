<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        @include('includes.docs.api.v3.head')
    </head>
    <body>

        <div class="container">
            <div class="row">
                <div class="col-3" id="sidebar">
                    <div class="column-content">
                        <div class="search-header">
                            <img src="/assets/img/logo.png" class="logo" alt="Logo" />
                            <input id="search" type="text" placeholder="Search">
                        </div>
                        <ul id="navigation">

                            <li><a href="#introduction">Introduction</a></li>

                            

                            <li>
                                <a href="#Api">Api</a>
                                <ul>
									<li><a href="#Api_token">token</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiUsers">ApiUsers</a>
                                <ul>
									<li><a href="#ApiUsers_get">get</a></li>

									<li><a href="#ApiUsers_current">current</a></li>

									<li><a href="#ApiUsers_token">token</a></li>

									<li><a href="#ApiUsers_cities">cities</a></li>

									<li><a href="#ApiUsers_login">login</a></li>

									<li><a href="#ApiUsers_subscribe">subscribe</a></li>

									<li><a href="#ApiUsers_save">save</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiItems">ApiItems</a>
                                <ul>
									<li><a href="#ApiItems_get">get</a></li>

									<li><a href="#ApiItems_all">all</a></li>

									<li><a href="#ApiItems_add">add</a></li>

									<li><a href="#ApiItems_save">save</a></li>

									<li><a href="#ApiItems_getBack">getBack</a></li>

									<li><a href="#ApiItems_savePicture">savePicture</a></li>

									<li><a href="#ApiItems_addMany">addMany</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiPickups">ApiPickups</a>
                                <ul>
									<li><a href="#ApiPickups_get">get</a></li>

									<li><a href="#ApiPickups_save">save</a></li>

									<li><a href="#ApiPickups_add">add</a></li>

									<li><a href="#ApiPickups_getList">getList</a></li>

									<li><a href="#ApiPickups_timeSlots">timeSlots</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiWarehouses">ApiWarehouses</a>
                                <ul>
									<li><a href="#ApiWarehouses_get">get</a></li>

									<li><a href="#ApiWarehouses_add">add</a></li>

									<li><a href="#ApiWarehouses_save">save</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiInvoices">ApiInvoices</a>
                                <ul>
									<li><a href="#ApiInvoices_get">get</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiNotifications">ApiNotifications</a>
                                <ul>
									<li><a href="#ApiNotifications_get">get</a></li>

									<li><a href="#ApiNotifications_add">add</a></li>

									<li><a href="#ApiNotifications_save">save</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiOrderAnswersQuestions">ApiOrderAnswersQuestions</a>
                                <ul>
									<li><a href="#ApiOrderAnswersQuestions_answers">answers</a></li>

									<li><a href="#ApiOrderAnswersQuestions_questions">questions</a></li>

									<li><a href="#ApiOrderAnswersQuestions_nextQuestion">nextQuestion</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiOrderCalculatorCategories">ApiOrderCalculatorCategories</a>
                                <ul>
									<li><a href="#ApiOrderCalculatorCategories_get">get</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiOrderCalculatorItems">ApiOrderCalculatorItems</a>
                                <ul>
									<li><a href="#ApiOrderCalculatorItems_get">get</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiOrderPlans">ApiOrderPlans</a>
                                <ul>
									<li><a href="#ApiOrderPlans_get">get</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiAreas">ApiAreas</a>
                                <ul>
									<li><a href="#ApiAreas_get">get</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiRegions">ApiRegions</a>
                                <ul>
									<li><a href="#ApiRegions_get">get</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiOrderPlanRegion">ApiOrderPlanRegion</a>
                                <ul>
									<li><a href="#ApiOrderPlanRegion_get">get</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiOrderPlanAssets">ApiOrderPlanAssets</a>
                                <ul>
									<li><a href="#ApiOrderPlanAssets_get">get</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiOrderAssurances">ApiOrderAssurances</a>
                                <ul>
									<li><a href="#ApiOrderAssurances_get">get</a></li>

									<li><a href="#ApiOrderAssurances_updateUser">updateUser</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiOrderStoringDurations">ApiOrderStoringDurations</a>
                                <ul>
									<li><a href="#ApiOrderStoringDurations_get">get</a></li>

									<li><a href="#ApiOrderStoringDurations_updateUser">updateUser</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#ApiArxminUsers">ApiArxminUsers</a>
                                <ul>
									<li><a href="#ApiArxminUsers_current">current</a></li>

									<li><a href="#ApiArxminUsers_token">token</a></li>

									<li><a href="#ApiArxminUsers_pickups">pickups</a></li>

									<li><a href="#ApiArxminUsers_login">login</a></li>
</ul>
                            </li>


                        </ul>
                    </div>
                </div>
                <div class="col-9" id="main-content">

                    <div class="column-content">

                        @include('includes.docs.api.v3.introduction')

                        <hr />

                                                

                                                <a href="#" class="waypoint" name="Api"></a>
                        <h2>Api</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="Api_token"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>token</h3></li>
                            <li>api/v3</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get request token.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">app_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) App id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="app_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">app_secret</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) App secret.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="app_secret">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiUsers"></a>
                        <h2>ApiUsers</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiUsers_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v3/users</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get users.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/users" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access Token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiUsers_current"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>current</h3></li>
                            <li>api/v3/users/current</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get current user informations.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/users/current" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiUsers_token"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>token</h3></li>
                            <li>api/v3/users/token</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Refresh access token.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/users/token" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Refresh token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiUsers_cities"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>cities</h3></li>
                            <li>api/v3/users/cities</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get cities.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/users/cities" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">locale</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Locale: en, fr, nl. Default: en.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="locale">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiUsers_login"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>login</h3></li>
                            <li>api/v3/users/login</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Login User and define a token lifetime (by default request = 6h, access_client = 6h, access_transporter = 14h, refresh_token = 90d)</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/users/login" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Request token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">email</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Email.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="email">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">password</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Password.</div>
                                <div class="parameter-value">
                                    <input type="password" class="parameter-value-text" name="password">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiUsers_subscribe"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>subscribe</h3></li>
                            <li>api/v3/users/subscribe</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Subscribe.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/users/subscribe" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Request token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">email</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Email, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="email">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">password</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Password.</div>
                                <div class="parameter-value">
                                    <input type="password" class="parameter-value-text" name="password">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first_name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) First name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first_name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">last_name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Last name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="last_name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">phone</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Phone.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="phone">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">lang</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Lang : en, fr, nl.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="lang">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">customer_type</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Customer type : private or professionnal. Default value is private.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="customer_type">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiUsers_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v3/users</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save informations of the current user.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/users" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access Token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">email</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Email, unique.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="email">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first_name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) First name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first_name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">last_name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Last name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="last_name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">postalcode</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Postal code.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="postalcode">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">add_infos</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Infos added.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="add_infos">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">city</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) City.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="city">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">box</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Box.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="box">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">number</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="number">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">street</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Street.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="street">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">latitude</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Latitude.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="latitude">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">longitude</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Longitude.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="longitude">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">phone</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Phone.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="phone">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">godfather_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) User godfather.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="godfather_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">lang</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Lang.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="lang">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">business</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Business: 1 or 0.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="business">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">password</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Password.</div>
                                <div class="parameter-value">
                                    <input type="password" class="parameter-value-text" name="password">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">active</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Active: 1 or 0.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="active">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">status</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Status: active or empty.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">avg_card</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Avantage card.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="avg_card">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">country</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Country.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="country">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">customer_type</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Customer type : private or professionnal. Default value is private.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="customer_type">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">file$id_card_file_recto</div>
                                <div class="parameter-type">\file</div>
                                <div class="parameter-desc">(optionnal) ID Card file recto.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="file$id_card_file_recto">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">file$id_card_file_verso</div>
                                <div class="parameter-type">\file</div>
                                <div class="parameter-desc">(optionnal) ID Card file verso.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="file$id_card_file_verso">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">oauth_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Facebook id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="oauth_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">last_order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Last order date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="last_order">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiItems"></a>
                        <h2>ApiItems</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiItems_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v3/items</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get items : selected items depend on Access token. If access token belong of a client, return items of the client. If access Token belong of a transporter, return all items managed by transporter. (All items returns a array, get items a JSON object)</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/items" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiItems_all"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>all</h3></li>
                            <li>api/v3/items/all</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get all items : Return dépend on Access token owner. If owner is a transporter, return all items. If owner is a user, return empty array.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/items/all" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiItems_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v3/items</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add an item.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/items" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">user_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Customer.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="user_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Pickup.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">ref</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Reference.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="ref">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">type</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Type: bike, box, suitcase, fridge, other...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="type">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">status</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Status: with_me, in_storage, in_transit.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">status_admin</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Status used for app and admin</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status_admin">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">description</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Description.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="description">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">file$photo</div>
                                <div class="parameter-type">\file</div>
                                <div class="parameter-desc">(optionnal) Photo.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="file$photo">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">weight</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Weight.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="weight">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">price</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Price.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="price">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">bulk_item</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Bulk item: 1 or 0.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="bulk_item">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">picture_option</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Picture option: 1 or 0.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="picture_option">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">street</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Street.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="street">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">number</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="number">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">box</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Box.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="box">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">postalcode</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Postal code.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="postalcode">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">city</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) City.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="city">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">longitude</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Longitude.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="longitude">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">latitude</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Latitude.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="latitude">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">add_infos</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Infos added.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="add_infos">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Pickup date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_option</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Pickup option: delayed, direct...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_option">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storage date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">ending_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Ending date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="ending_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">billing_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Billing date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="billing_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">billing_status</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Billing status: pending, unpaid...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="billing_status">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">billing_ref</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Billing_ref.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="billing_ref">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">box_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Box id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="box_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_country</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing country.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_country">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_warehouse</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing warehouse.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_warehouse">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_floor</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing floor.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_floor">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_row</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing row.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_row">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_rack</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing rack.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_rack">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_rack_floor</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing rack flood.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_rack_floor">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_pallet</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing pallet.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_pallet">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">intern_note</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Intern note.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="intern_note">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">price_estimation</div>
                                <div class="parameter-type">double</div>
                                <div class="parameter-desc">(optionnal) Price estimation.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="price_estimation">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">volume_m3</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Volume in cubic meters.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="volume_m3">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order_assurance_id</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc">(optionnal) Id of the order_assurance</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_assurance_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">datetime$end_commitement_date</div>
                                <div class="parameter-type">\datetime</div>
                                <div class="parameter-desc">(optionnal) Id end of the end commitement</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="datetime$end_commitement_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">fragile</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) if item is fragile or not</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="fragile">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiItems_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v3/items</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save an item.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/items" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">user_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Customer.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="user_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Pickup.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">ref</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Reference.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="ref">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">type</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Type: bike, box, suitcase, fridge, other...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="type">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">status</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Status: with_me, in_storage, in_transit.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">status_admin</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Status used for app and admin</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status_admin">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Name.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">description</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Description.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="description">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">file$photo</div>
                                <div class="parameter-type">\file</div>
                                <div class="parameter-desc">(optionnal) Photo.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="file$photo">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">weight</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Weight.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="weight">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">price</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Price.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="price">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">bulk_item</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Bulk item: 1 or 0.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="bulk_item">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">picture_option</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Picture option: 1 or 0.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="picture_option">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">street</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Street.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="street">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">number</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="number">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">box</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Box.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="box">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">postalcode</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Postal code.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="postalcode">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">city</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) City.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="city">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">longitude</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Longitude.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="longitude">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">latitude</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Latitude.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="latitude">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">add_infos</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Infos added.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="add_infos">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Pickup date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_option</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Pickup option: delayed, direct...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_option">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storage date.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">ending_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Ending date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="ending_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">billing_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Billing date.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="billing_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">billing_status</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Billing status: pending, unpaid...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="billing_status">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">billing_ref</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Billing_ref.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="billing_ref">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">box_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Box id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="box_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_country</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing country.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_country">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_warehouse</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing warehouse.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_warehouse">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_floor</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing floor.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_floor">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_row</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing row.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_row">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_rack</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing rack.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_rack">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_rack_floor</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing rack flood.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_rack_floor">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_pallet</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storing pallet.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_pallet">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">intern_note</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Intern note.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="intern_note">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">price_estimation</div>
                                <div class="parameter-type">double</div>
                                <div class="parameter-desc">(optionnal) Price estimation.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="price_estimation">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">volume_m3</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Volume in cubic meters.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="volume_m3">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order_assurance_id</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc">(optionnal) Id of the order_assurance</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_assurance_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">datetime$end_commitement_date</div>
                                <div class="parameter-type">\datetime</div>
                                <div class="parameter-desc">(optionnal) Id end of the end commitement</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="datetime$end_commitement_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">fragile</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) if item is fragile or not</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="fragile">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiItems_getBack"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>getBack</h3></li>
                            <li>api/v3/items/getback</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Allows the user to repatriate items, change of status of the item, the creation of the pickup, .</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc">.. <br />Sub_error 0 : token not found. 1 : token expired. 2 : required data missing, 3 : bad formatting date, 4 : bad date</p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/items/getback" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) id of items to pickoff. Format {"0":id1,"1":id2,...}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required)  Pickoff date to. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">postalcode</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Postal code (if null client ZipCode)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="postalcode">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">add_infos</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Infos added (if null client's add_infos)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="add_infos">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">city</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) City (if null client's City)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="city">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">box</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Box (if null client's Box)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="box">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">number</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Number (if null client's Number)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="number">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">street</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Street (if null client's Street)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="street">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">phone</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Phone (if null client's Phone)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="phone">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">country</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Country (if null client's Country)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="country">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">answers_services</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Answers to Order Questions Format : {"id_question1":"answer1","id_question2":"answer2",...}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="answers_services">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiItems_savePicture"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>savePicture</h3></li>
                            <li>api/v3/items/savePicture</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a picture to an item.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/items/savePicture" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">objet_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Id de l'objet</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="objet_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">box_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) reference de l'objet</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="box_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">image</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Image envoyé en base64.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="image">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiItems_addMany"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>addMany</h3></li>
                            <li>api/v3/items/many</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add many items</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/items/many" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first_ref</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc">(required) First Id of client</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first_ref">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">last_ref</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc">(required) First Id of next client</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="last_ref">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">user_id</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc">(required) id of user</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="user_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_id</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc">(required) id of pickup</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storage_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Storage date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storage_date">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiPickups"></a>
                        <h2>ApiPickups</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiPickups_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v3/pickups</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get pickups.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/pickups" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiPickups_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v3/pickups</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Save an pickup.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/pickups" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">user_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Customer.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="user_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">total</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Total.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="total">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">street</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Street.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="street">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">number</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="number">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">box</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Box.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="box">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">postalcode</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Postal code.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="postalcode">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">city</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) City.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="city">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">status</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Status: ordered, getback.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">add_infos</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Infos added.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="add_infos">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">history</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) History.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="history">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Pickup date from. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">file$sign_photo</div>
                                <div class="parameter-type">\file</div>
                                <div class="parameter-desc">(optionnal) Sign photo.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="file$sign_photo">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">intern_note</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Intern note.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="intern_note">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">dropoff_date_from</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Dropoff date from. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="dropoff_date_from">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">dropoff_intern_note</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Dropoff intern note.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="dropoff_intern_note">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">dropoff_date_to</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Dropoff date to. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="dropoff_date_to">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_date_to</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal)  Pickup date to. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_date_to">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_option</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal)  Pickup option.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_option">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order_booking_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Booking.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_booking_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiPickups_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v3/pickups</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a pickup.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/pickups" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">user_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Customer.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="user_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">total</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Total.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="total">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">street</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Street.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="street">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">number</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Number.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="number">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">box</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Box.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="box">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">postalcode</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Postal code.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="postalcode">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">city</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) City.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="city">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">status</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Status: ordered, getback.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">add_infos</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Infos added.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="add_infos">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">history</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) History.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="history">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_date</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Pickup date from. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_date">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">file$sign_photo</div>
                                <div class="parameter-type">\file</div>
                                <div class="parameter-desc">(optionnal) Sign photo.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="file$sign_photo">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">intern_note</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Intern note.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="intern_note">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">dropoff_date_from</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Dropoff date from. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="dropoff_date_from">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">dropoff_intern_note</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Dropoff intern note.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="dropoff_intern_note">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">dropoff_date_to</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Dropoff date to. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="dropoff_date_to">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_date_to</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal)  Pickup date to. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_date_to">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">pickup_option</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal)  Pickup option.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="pickup_option">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order_booking_id</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Booking.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order_booking_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiPickups_getList"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>getList</h3></li>
                            <li>api/v3/pickups/list</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get all pickup information according the kind of user/n</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc">User : Access, when & status/n

Transporter : Access, when & status/n

Admin : Permet de récupérer le planning soit général (cat = all, status = all, when = all), soit les plannings plus spécifiques (par exemple le planning d'un livreur en particuler : cat=transporter, email_user) ou les pick-up n'ayant pas encore de livreurs attribués</p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/pickups/list" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access Token</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">when</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Period concerned. Value : history, future, today, all. Default value : all.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="when">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">status</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Status of the pickup. Values : ordered, getback, all. Default value : all.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">canceled</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) including canceled pickup : 1 = true; 0 = false. Default value : 0</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="canceled">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">cat</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Category of pickup showed. Values : transporter, user, not-attributed, all. Default value : all. (only used by admin)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="cat">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">email_user</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) user / transporter email (only used by admin with "transporter" or "user" value on $cat)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="email_user">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiPickups_timeSlots"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>timeSlots</h3></li>
                            <li>api/v3/pickups/timeslots</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get time slots.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/pickups/timeslots" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">from</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) From. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="from">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">to</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) To. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="to">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiWarehouses"></a>
                        <h2>ApiWarehouses</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiWarehouses_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v3/warehouses</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get warehouse</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/warehouses" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiWarehouses_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v3/warehouses</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a pickup.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/warehouses" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">ref</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Reference of warehouse (3 letters).</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="ref">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Complete name of the warehouse.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">country</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) country of the warehouse.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="country">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">city</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) city of the warehouse.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="city">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">number</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) number of the warehouse.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="number">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">street</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) street of the warehouse.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="street">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">latitude</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) latitude of the warehouse.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="latitude">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">longitude</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) longitude of the warehouse.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="longitude">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiWarehouses_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v3/warehouses</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Update a warehouse</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/warehouses" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">ref$ref</div>
                                <div class="parameter-type">\ref</div>
                                <div class="parameter-desc">(optionnal) Reference</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="ref$ref">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Complete name of the warehouse.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">country</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) country of the warehouse.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="country">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">city</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) city of the warehouse.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="city">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">number</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) number of the warehouse.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="number">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">street</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) street of the warehouse.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="street">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">latitude</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) latitude of the warehouse.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="latitude">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">longitude</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) longitude of the warehouse.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="longitude">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">created_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Created date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="created_at">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">updated_at</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Updated date. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="updated_at">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiInvoices"></a>
                        <h2>ApiInvoices</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiInvoices_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v3/invoices</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get invoices : works only for user. Return his invoices</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/invoices" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiNotifications"></a>
                        <h2>ApiNotifications</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiNotifications_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v3/notifications</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get notification</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/notifications" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiNotifications_add"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>add</h3></li>
                            <li>api/v3/notifications</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Add a notification</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/notifications" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) slug</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">detail_json</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) details in json</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="detail_json">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiNotifications_save"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>save</h3></li>
                            <li>api/v3/notifications</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Update a notification</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/notifications" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) Id.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">slug</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnel) slug</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="slug">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">detail_json</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnel) details in json</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="detail_json">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiOrderAnswersQuestions"></a>
                        <h2>ApiOrderAnswersQuestions</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiOrderAnswersQuestions_answers"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>answers</h3></li>
                            <li>api/v3/order/answers</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get all anwsers.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/order/answers" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderAnswersQuestions_questions"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>questions</h3></li>
                            <li>api/v3/order/questions</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get all questions.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/order/questions" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">locale</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Lang : fr, en, nl</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="locale">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderAnswersQuestions_nextQuestion"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>nextQuestion</h3></li>
                            <li>api/v3/order/questions/next</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get next questions (under construction). return array ("text_answer"=>(string), "fees"=>(int), "answer_id"=>(int), "text_question"=>(string), "type_question"=>({boolean|number}), "question_id"=>(int), "img_question"=>(string)) OR status 400.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/order/questions/next" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">question_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) id previous question. NULL for first.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="question_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">answer</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) 0 OR 1 for boolean answer, int for number, NULL for first.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="answer">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">volume</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(required) volume of the pick-up</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="volume">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiOrderCalculatorCategories"></a>
                        <h2>ApiOrderCalculatorCategories</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiOrderCalculatorCategories_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v3/order/calculator/categories</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get calculator categories.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/order/calculator/categories" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">locale</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Lang : en, fr, nl. Default : en.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="locale">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiOrderCalculatorItems"></a>
                        <h2>ApiOrderCalculatorItems</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiOrderCalculatorItems_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v3/order/calculator/items</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get calculator items.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/order/calculator/items" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">lang</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Locale.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="lang">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiOrderPlans"></a>
                        <h2>ApiOrderPlans</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiOrderPlans_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v3/order/plans</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get plans.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/order/plans" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">lang</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Locale.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="lang">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiAreas"></a>
                        <h2>ApiAreas</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiAreas_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v3/areas</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get areas. Use filters=zip_code:=:{value} and first to have region_id</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/areas" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiRegions"></a>
                        <h2>ApiRegions</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiRegions_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v3/regions</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get Regions (link between id and name)</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/regions" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiOrderPlanRegion"></a>
                        <h2>ApiOrderPlanRegion</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiOrderPlanRegion_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v3/order/plans/regions</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get plan by region, acccording to the postal code.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/order/plans/regions" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">postalCode</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Postal code of order.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="postalCode">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiOrderPlanAssets"></a>
                        <h2>ApiOrderPlanAssets</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiOrderPlanAssets_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v3/order/plans/assets</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get plan assets.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/order/plans/assets" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">locale</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) lang : en, fr, nl. default : en.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="locale">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiOrderAssurances"></a>
                        <h2>ApiOrderAssurances</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiOrderAssurances_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v3/order/assurances</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get assurances</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/order/assurances" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">locale</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) lang : en, fr, nl. default : en.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="locale">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderAssurances_updateUser"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>updateUser</h3></li>
                            <li>api/v3/order/assurances/user</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">update assurance user</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/order/assurances/user" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">insurance</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) slug of new assurance</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="insurance">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiOrderStoringDurations"></a>
                        <h2>ApiOrderStoringDurations</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiOrderStoringDurations_get"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>get</h3></li>
                            <li>api/v3/order/duration</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get storing durations.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/order/duration" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">filters</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Filter the results. Model: {attribute1}:{operator1}:{value1};{attribute2}:{operator2}:{value2}...</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="filters">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">order</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(optionnal) Sort the result. Model: {attribute}:{way}</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="order">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Current page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">items_by_page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">(optionnal) Items by page for pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="items_by_page">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first</div>
                                <div class="parameter-type">boolean</div>
                                <div class="parameter-desc">(optionnal) Force the results to only one item. Not working with pagination.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiOrderStoringDurations_updateUser"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>updateUser</h3></li>
                            <li>api/v3/order/duration/user</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">update storing duration of user</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/order/duration/user" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">storing_duration</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) slug of new storing duration</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="storing_duration">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="ApiArxminUsers"></a>
                        <h2>ApiArxminUsers</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="ApiArxminUsers_current"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>current</h3></li>
                            <li>api/v3/arxmin/users/current</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get current transporter informations.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/arxmin/users/current" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiArxminUsers_token"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>token</h3></li>
                            <li>api/v3/arxmin/users/token</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Refresh access token.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/arxmin/users/token" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Refresh token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiArxminUsers_pickups"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>pickups</h3></li>
                            <li>api/v3/arxmin/users/pickups</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Get transporter pickups.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/arxmin/users/pickups" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Access token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">from</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) From. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="from">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">to</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) To. Format: YYYY-MM-DD HH:MM:SS.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="to">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="ApiArxminUsers_login"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>login</h3></li>
                            <li>api/v3/arxmin/users/login</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Login.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v3/arxmin/users/login" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Request token.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">email</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Email.</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="email">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">password</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">(required) Password.</div>
                                <div class="parameter-value">
                                    <input type="password" class="parameter-value-text" name="password">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>


                    </div>
                </div>
            </div>
        </div>


    </body>
</html>

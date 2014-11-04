<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Tables - Stilearn Admin Bootstrap</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="" />
        <meta name="author" content="stilearning" />

        <!-- google font -->
        <link href="http://fonts.googleapis.com/css?family=Aclonica:regular" rel="stylesheet" type="text/css" />

        <!-- styles -->
        <link href="/static/css/bootstrap-vivian.css" rel="stylesheet" />
        <link href="/static/css/bootstrap-responsive.css" rel="stylesheet" />
        <link href="/static/css/stilearn.css" rel="stylesheet" />
        <link href="/static/css/stilearn-responsive.css" rel="stylesheet" />
        <link href="/static/css/stilearn-helper.css" rel="stylesheet" />
        <link href="/static/css/stilearn-icon.css" rel="stylesheet" />
        <link href="/static/css/font-awesome.css" rel="stylesheet" />
        <link href="/static/css/DT_bootstrap.css" rel="stylesheet" />
        <link href="/static/css/responsive-tables.css" rel="stylesheet" />
        
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

<body>
    <!-- section header -->
    <header class="header" data-spy="affix" data-offset-top="0">
        <!--nav bar helper-->
        <div class="navbar-helper">
            <div class="row-fluid">
                <!--panel site-name-->
                <div class="span2">
                    <div class="panel-sitename">
                        <h2><a href="/vivian/"><span class="color-teal">Sti</span>learn</a></h2>
                    </div>
                </div>
                <!--/panel name-->

                <div class="span6">
                    <!--panel search-->
                    <div class="panel-search">
                        <form />
                            <div class="input-icon-append">
                                <button type="submit" rel="tooltip-bottom" title="search" class="icon"><i class="icofont-search"></i></button>
                                <input class="input-large search-query grd-white" maxlength="23" placeholder="Search here..." type="text" />
                            </div>
                        </form>
                    </div><!--/panel search-->
                </div>
                <div class="span4">
                    <!--panel button ext-->
                    <div class="panel-ext">
                        
                        <div class="btn-group">
                            <a class="btn btn-inverse btn-small" href="javascript:void(0);">wushuiyong</a>
                        </div>
                        &nbsp;
                        <div class="btn-group user-group">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <img class="corner-all" align="middle" src="/static/images/user-thumb.jpg" title="John Doe" alt="john doe" /> <!--this for display on PC device-->
                                <button class="btn btn-small btn-inverse">John Doe</button> <!--this for display on tablet and phone device-->
                            </a>
                           
                        </div>
                    </div><!--panel button ext-->
                </div>
            </div>
        </div><!--/nav bar helper-->
    </header>

    <!-- section content -->
    <section class="section">
        <div class="row-fluid">
            <!-- span side-left -->
            <div class="span1">
                <!--side bar-->
                <aside class="side-left">
                    <ul class="sidebar">
                        <li class="active">
                            <a href="/vivian/index/" title="table">
                                <div class="helper-font-24">
                                    <i class="icofont-table"></i>
                                </div>
                                <span class="sidebar-text">姓氏</span>
                            </a>
                        </li>

                        <li>
                            <a href="index.html" title="dashboard">
                                <div class="helper-font-24">
                                    <i class="icofont-dashboard"></i>
                                </div>
                                <span class="sidebar-text">Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" title="more">
                                <div class="helper-font-24">
                                    <i class="icofont-th-large"></i>
                                </div>
                                <span class="sidebar-text">More</span>
                            </a>
                            
                        </li>
                    </ul>
                </aside><!--/side bar -->
            </div><!-- span side-left -->
            
            <!-- span content -->
            <div class="span11">
                <!-- content -->
                <div class="content">
                    <!-- content-header -->
                    <div class="content-header">
                        <h2><i class="icofont-table"></i>姓氏</h2>
                    </div><!-- /content-header -->
                    
                    <!-- content-breadcrumb -->
                    <div class="content-breadcrumb">
                        <!--breadcrumb-->
                        <ul class="breadcrumb">
                            <li><a href="index.html"><i class="icofont-home"></i> 姓氏</a> <span class="divider">&rsaquo;</span></li>
                            <li class="active">列表</li>
                        </ul><!--/breadcrumb-->
                    </div><!-- /content-breadcrumb -->
                    
                    <!-- content-body -->
                    <div class="content-body">
                        <!--datatables-->
                        <div id="invoice-container" class="invoice-container">
                            <h3><?= $nameInfo['xinshi'] ?> &nbsp; <?= $nameInfo['name'] ?> <small><?= $gender ?></small></h3>
                            <div class="divider-content"><span></span></div>
                            <div class="row-fluid">
                                <div class="span4">
                                    <p class="muted">From</p>
                                    <?php foreach ($explain as $k => $v) { ?>
                                    <p><?= $k ?> &nbsp; 
                                    <?= $v['pinyin'] ?> &nbsp; 
                                    <?= $v['old'] ?>&nbsp;
                                    <?= $v['pop'] ?>&nbsp;
                                    </p>
                                    <?php } ?>
                                </div>
                                <div class="span4">
                                    <p class="muted">To</p>
                                    <p>XYZ Corp</p>
                                    <p>432 Main Street</p>
                                    <p>San Francisco, CA 91234</p>
                                </div>
                                <div class="span4">
                                    <div class="span4 demo-knob">
                                        <input data-chart="knob" data-width="120" data-displayprevious="true" data-fgcolor="#643EBF" data-skin="tron" data-thickness=".1" value="75" />
                                    </div>
                                </div>
                            </div>
                          
                        </div>
                        <!--/tables-->
                    </div><!--/content-body -->
                </div><!-- /content -->
            </div><!-- /span content -->
            
        </div>
    </section>

    <!-- section footer -->
    <footer>
        <a rel="to-top" href="#top"><i class="icofont-circle-arrow-up"></i></a>
    </footer>

    <!-- javascript
    ================================================== -->
    <script src="/static/js/jquery.js"></script>
    <script src="/static/js/bootstrap.js"></script>
    <script src="/static/js/uniform/jquery.uniform.js"></script>
    
    <script src="/static/js/jquery.knob.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
                // to view the configuration flot chart you can see the file jquery.flot.demo.js
                
                // uniform
                $('[data-form=uniform]').uniform();
                
                // knob (include for skin setting)
                $('[data-chart=knob]').knob({
                    draw : function () {

                        // "tron" case
                        if(this.$.data('skin') == 'tron') {

                            var a = this.angle(this.cv)  // Angle
                                , sa = this.startAngle          // Previous start angle
                                , sat = this.startAngle         // Start angle
                                , ea                            // Previous end angle
                                , eat = sat + a                 // End angle
                                , r = 1;

                            this.g.lineWidth = this.lineWidth;

                            this.o.cursor
                                && (sat = eat - 0.3)
                                && (eat = eat + 0.3);

                            if (this.o.displayPrevious) {
                                ea = this.startAngle + this.angle(this.v);
                                this.o.cursor
                                    && (sa = ea - 0.3)
                                    && (ea = ea + 0.3);
                                this.g.beginPath();
                                this.g.strokeStyle = this.pColor;
                                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                                this.g.stroke();
                            }

                            this.g.beginPath();
                            this.g.strokeStyle = r ? this.o.fgColor : this.fgColor ;
                            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
                            this.g.stroke();

                            this.g.lineWidth = 2;
                            this.g.beginPath();
                            this.g.strokeStyle = this.o.fgColor;
                            this.g.arc( this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                            this.g.stroke();

                            return false;
                        }
                    }
                });
                
            });
            
    </script>
</body>
</html>

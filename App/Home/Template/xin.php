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
                        <h2><a href="index.html"><span class="color-teal">Sti</span>learn</a></h2>
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
                            <a href="tables.html" title="table">
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
                        <!-- tables -->
                        <!--datatables-->
                        <div class="row-fluid">
                            <div class="span12">
                                <div class="box corner-all">
                                    <div class="box-body" style="border:none;">
                                        <table id="datatables" class="table table-bordered table-striped responsive">
                                            <thead>
                                                <tr>
                                                    <th>姓名</th>
                                                    <th>性别</th>
                                                    <th>姓氏</th>
                                                    <th>名字数量</th>
                                                    <!-- <th>CSS grade</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($names as $k => $v) { ?>
                                                <tr>
                                                    <td><a href="/vivian/name/<?= $v['id'] ?>"><?= $xinInfo['xin'] . $v['name'] ?></a></td>
                                                    <td><?= $gender[$v['gender']] ?></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        
                                    </div><!-- /box-body -->
                                </div><!-- /box -->
                            </div><!-- /span -->
                        </div><!--/datatables-->
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
    
    <script src="/static/js/datatables/jquery.dataTables.min.js"></script>
    <script src="/static/js/datatables/extras/ZeroClipboard.js"></script>
    <script src="/static/js/datatables/extras/TableTools.min.js"></script>
    <script src="/static/js/datatables/DT_bootstrap.js"></script>
    <script src="/static/js/responsive-tables.js"></script>
    
    <!-- required stilearn template js, for full feature-->
    <script src="/static/js/holder.js"></script>
    <script src="/static/js/stilearn-base.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            // try your js
            
            // uniform
            $('[data-form=uniform]').uniform();
            
            // datatables
            $('#datatables').dataTable( {
                "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                        "sLengthMenu": "_MENU_ records per page"
                }
            });
            
            // datatables table tools
            $('#datatablestools').dataTable({
                "sDom": "<'row-fluid'<'span6'T><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
                "oTableTools": {
                    "aButtons": [
                        "copy",
                        "print",
                        {
                            "sExtends":    "collection",
                            "sButtonText": 'Save <span class="caret" />',
                            "aButtons":    [ 
                                "xls", 
                                "csv",
                                {
                                    "sExtends": "pdf",
                                    "sPdfOrientation": "landscape",
                                    "sPdfMessage": "Your custom message would go here."
                                }
                            ]
                        }
                    ],
                    "sSwfPath": "/static/js/datatables/swf/copy_csv_xls_pdf.swf"
                }
            });
        });
  
    </script>
</body>
</html>

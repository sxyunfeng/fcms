<!Doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,Chrome=1" />
<meta http-equiv="X-UA-Compatible" content="IE=9" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link rel="stylesheet" href="/bootstrap/3.3.0/css/bootstrap.css" />
<link rel="stylesheet" href="/css/install/main.css" />
<style type="text/css">

</style>
<title>环境检测</title>
</head>
<body>
    
    
    <div class="container self_main">
    
        <!-- 标题 -->
        <div class="row">
            <div class="col-xs-12">
                <div class="page-header self_header">
                    <p><em>FCMS安装向导</em></p>
                </div>
            </div>
        </div>
        
        <!-- 内容 -->
        <div class="row">
        
            <!-- 流程 -->
            <div class="col-xs-3">
                <ul class="self_procedure">
                    <li><button class="self_btn_circular">安装须知</button></li>
                    <li><button class="self_btn_circular_active">环境检测</button></li>
                    <li><button class="self_btn_circular">数据创建</button></li>
                    <li><button class="self_btn_circular">完成安装</button></li>
                </ul>
            </div>
            
            <!-- 正文 -->
            <div class="col-xs-9">
            
                <!-- 安全环境检测 -->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="panel self_panel">
                            <div class="panel-heading self_panel_heading"><h4>安装环境检测</h4></div>
                            <table class="table table-striped table-hover self_table">
                                <thead>
                                    <tr>
                                        <th>检测项目</th>
                                        <th>所需配置</th>
                                        <th>最佳配置</th>
                                        <th>当前配置</th>
                                        <th>检测状态</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>操作系统</td>
                                        <td>不限制</td>
                                        <td>Unix内核</td>
                                        <td><?php echo $systemInfo; ?></td>
                                        <td><?php echo $systemId; ?></td>
                                    </tr>
                                    <tr>
                                        <td>WEB服务器</td>
                                        <td>Apache/Nginx/IIS</td>
                                        <td>Apache 2.4/Nginx 1.7/IIS 8.0</td>
                                        <td><?php echo $serverInfo; ?></td>
                                        <td class="necessaryItem"><span class="glyphicon glyphicon-ok" style="color:green;"></span></td>
                                    </tr>
                                    <tr>
                                        <td>PHP版本</td>
                                        <td>5.3/5.4/5.5/5.6</td>
                                        <td>5.5/5.6</td>
                                        <td><?php echo $phpVersion; ?></td>
                                        <td class="necessaryItem"><?php echo $phpVersionId; ?></td>
                                    </tr>
                                    <tr>
                                        <td>文件上传</td>
                                        <td>≥2M</td>
                                        <td>≥2M</td>
                                        <td><?php echo $uploadLimitInfo; ?></td>
                                        <td class="necessaryItem"><?php echo $uploadLimitId; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>脚本内存限制(memory_limit)</td>
                                        <td>≥128M</td>
                                        <td>≥128M</td>
                                        <td><?php echo $memoryLimitInfo; ?></td>
                                        <td class="necessaryItem"><?php echo $memoryLimitId; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>Mysql扩展</td>
                                        <td>必须</td>
                                        <td>支持</td>
                                        <td><?php echo $mysqlInfo; ?></td>
                                        <td class="necessaryItem"><?php echo $mysqlId; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Mysqli扩展</td>
                                        <td>必须</td>
                                        <td>支持</td>
                                        <td><?php echo $mysqliInfo; ?></td>
                                        <td class="necessaryItem"><?php echo $mysqliId; ?></td>
                                    </tr>
                                    <tr>
                                        <td>PDO_Mysql扩展</td>
                                        <td>必须</td>
                                        <td>支持</td>
                                        <td><?php echo $pdo_mysqlInfo; ?></td>
                                        <td class="necessaryItem"><?php echo $pdo_mysqlId; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Phalcon扩展</td>
                                        <td>必须</td>
                                        <td>支持</td>
                                        <td><?php echo $phalconInfo; ?></td>
                                        <td class="necessaryItem"><?php echo $phalconId; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Curl扩展</td>
                                        <td>必须</td>
                                        <td>支持</td>
                                      	<td><?php echo $curlInfo; ?></td>
                                        <td class="necessaryItem"><?php echo $curlId; ?></td>
                                    </tr>
                                    <tr>
                                        <td>GD扩展</td>
                                        <td>必须</td>
                                        <td>支持</td>
                                        <td><?php echo $gdInfo; ?></td>
                                        <td class="necessaryItem"><?php echo $gdId; ?></td>
                                    </tr>
                                    <tr>
                                        <td>APC扩展</td>
                                        <td>可选</td>
                                        <td>支持</td>
                                        <td><?php echo $apcInfo; ?></td>
                                        <td><?php echo $apcId; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Mongo扩展</td>
                                        <td>可选</td>
                                        <td>支持</td>
                                        <td><?php echo $mongoInfo; ?></td>
                                        <td><?php echo $mongoId; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Memcache扩展</td>
                                        <td>可选</td>
                                        <td>支持</td>
                                        <td><?php echo $memcacheInfo; ?></td>
                                        <td><?php echo $memcacheId; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Memcached扩展</td>
                                        <td>可选</td>
                                        <td>支持</td>
                                        <td><?php echo $memcachedInfo; ?></td>
                                        <td><?php echo $memcachedId; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- 部署权限检测 -->
                <div class="row" style="margin-top:20px;">
	                <div class="col-xs-12">
	                    <div class="panel self_panel">
	                        <div class="panel-heading self_panel_heading"><h4>部署权限检测<span style="font-size:14px;">（必须）</span></h4></div>
	                        <table class="table table-striped table-hover self_table">
	                            <thead>
	                                <tr>
	                                    <th>部署内容</th>
	                                    <th>安装目录</th>
	                                    <th>写入权限</th>
	                                </tr>
	                            </thead>
	                            <tbody>
	                                <tr>
	                                    <td>installCache</td>
	                                    <td><?php echo $installCachePath; ?></td>
	                                    <td class="necessaryItem"><?php echo $installCacheWriteId; ?></td>
	                                </tr>
	                                <tr>
	                                    <td>cmsCache</td>
	                                    <td><?php echo $cmsCachePath; ?></td>
	                                    <td class="necessaryItem"><?php echo $cmsCacheWriteId; ?></td>
	                                </tr>
	                                <tr>
	                                    <td>adminCache</td>
	                                    <td><?php echo $adminCachePath; ?></td>
	                                    <td class="necessaryItem"><?php echo $adminCacheWriteId; ?></td>
	                                </tr>
	                                
	                                <tr>
	                                    <td>config/config.php</td>
	                                    <td><?php echo $configPath; ?></td>
	                                    <td class="necessaryItem"><?php echo $configWriteId; ?></td>
	                                </tr>
	                                <tr>
	                                    <td>config/router.php</td>
	                                    <td><?php echo $routerPath; ?></td>
	                                    <td class="necessaryItem"><?php echo $routerWriteId; ?></td>
	                                </tr>
	                                <tr>
	                                    <td>logs/fcms_install_logs.txt</td>
	                                    <td><?php echo $logsPath; ?></td>
	                                    <td class="necessaryItem"><?php echo $logsWriteId; ?></td>
	                                </tr>
	                               <!--   <tr>
	                                    <td>config/config.php</td>
	                                    <td><?php echo $configPath; ?></td>
	                                    <td class="necessaryItem"><?php echo $configWriteId; ?></td>
	                                    <td class="necessaryItem"><?php echo $configReadId; ?></td>
	                                </tr>
	                                <tr>
	                                    <td>logs/fcms_install_logs.txt</td>
	                                    <td><?php echo $logsPath; ?></td>
	                                    <td class="necessaryItem"><?php echo $logsWriteId; ?></td>
	                                    <td class="necessaryItem"><?php echo $logsReadId; ?></td>
	                                </tr>
	                                <tr>
	                                    <td>config/router.php</td>
	                                    <td><?php echo $routerPath; ?></td>
	                                    <td class="necessaryItem"><?php echo $routerWriteId; ?></td>
	                                    <td class="necessaryItem"><?php echo $routerReadId; ?></td>
	                                </tr>
	                                <tr>
	                                    <td>install/cache</td>
	                                    <td><?php echo $cache1Path; ?></td>
	                                    <td class="necessaryItem"><?php echo $cache1WriteId; ?></td>
	                                    <td class="necessaryItem"><?php echo $cache1ReadId; ?></td>
	                                </tr>
	                                <tr>
	                                    <td>cms/cache</td>
	                                    <td><?php echo $cache2Path; ?></td>
	                                    <td class="necessaryItem"><?php echo $cache2WriteId; ?></td>
	                                    <td class="necessaryItem"><?php echo $cache2ReadId; ?></td>
	                                </tr>
	                                <tr>
	                                    <td>admin/cache</td>
	                                    <td><?php echo $cache3Path; ?></td>
	                                    <td class="necessaryItem"><?php echo $cache3WriteId; ?></td>
	                                    <td class="necessaryItem"><?php echo $cache3ReadId; ?></td>
	                                </tr>-->
	                            </tbody>
	                        </table>
	                    </div>
	                </div>
                </div>
                
            </div>
            
        </div>
        
        <div class="row">
            <div class="col-xs-12">
                <!-- 上、下一步按钮 -->
                <div class="row self_choose_step">
                    <!-- 上一步 -->
                    <div class="col-xs-6 text-left">
                        <a href="/install/index/index" class="btn btn-danger btn-lg self_btn_normal">上一步</a>
                    </div>
                    
                    <!-- 下一步 -->
                    <div class="col-xs-6 text-right">
                        <a href="/install/index/create" class="btn btn-danger btn-lg self_btn_normal" onclick="return checkAllId()">下一步</a>
                    </div>
                    
                </div>
            </div>
        </div>
        
    </div>


<script src="/js/jquery/jquery-1.11.1.min.js"></script>
<script src="/bootstrap/3.3.0/js/bootstrap.js"></script>
<script src="/js/install/html5shiv.js"></script>
<script src="/js/install/respond.js"></script>
<script src="/js/install/extensionsCheck.js"></script>

</body>
</html>
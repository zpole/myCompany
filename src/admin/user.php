<?
require_once(dirname(__FILE__).'/../config.php');
require_once(WebRoot."/login/loginLib.php");
require_once(WebRoot."/lib/mysql.php");
isLogin();

$selectOK = $database->get("select_sb","val",[]);
?>
  <!DOCTYPE html>
  <html>

  <head>
    <title>修改用户-管理员-ACME公司管理系统</title>
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../asset/materialize/css/materialize.min.css" media="screen,projection" />
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="shortcut icon" href="../icons/material-design-icons/action/1x_web/ic_account_circle_black_48dp.png" size="32x32">
    <link rel="icon" href="../icons/material-design-icons/action/1x_web/ic_account_circle_black_48dp.png" sizes="32x32">
  </head>

  <body class=" grey lighten-3">



<ul id="slide-out" class="side-nav">
    <li><div class="userView">
      <div class="background">
        <img src="../images/office.jpg">
      </div>
      <a href="#!user"><img class="circle" src="../images/g.jpg"></a>
      <a href="#!name"><span class="white-text name">管理员</span></a>
      <a href="#!email"><span class="white-text email">ACME网络有限公司</span></a>
    </div></li>
    <li><a href="user.php"><i class="material-icons">assignment_ind</i>修改用户</a></li>
    <li><a href="subject.php"><i class="material-icons">recent_actors</i>修改项目</a></li>
    <li><a href="report.php"><i class="material-icons">open_in_browser</i>打印报告</a></li>
    <li><a href="../2017-25weekPaycheck.html" target="_blank"><i class="material-icons">open_in_browser</i>周报告</a></li>
    <li><a href="../2017-06monthPaycheck.html" target="_blank"><i class="material-icons">open_in_browser</i>月工资</a></li>
    <li><div class="divider"></div></li>
    <li><a class="waves-effect" href="index.php"><i class="material-icons">store</i>主页面</a></li>
    <li><a href="#" onClick="showSettings();"><i class="material-icons">settings</i>设置</a></li>
    <li><a href="../login/index.php" onClick="delAllCookie();"><i class="material-icons">replay</i>登出</a></li>
  </ul>



  <nav>
    <div class="nav-wrapper blue">
    <a href="#" class="brand-logo center"><i class="material-icons">supervisor_account</i>管理员</a>
    </div>
  </nav>


    <div class="row">
      <br>
      <h5 class="center">以下为所有用户的信息</h5>
      <br>
    </div>
    <div class="container">
      <table id="haowan" class="responsive-table centered z-depth-3 white">
        <thead>
          <tr>
            <th data-field="id" type="number">账号</th>
            <th data-field="id" type="number">工号</th>
            <th data-field="name" type="string">用户名</th>
            <th data-field="phone" type="number">联系电话</th>
            <th data-field="type" type="string">用户类型</th>
            <th data-field="ps" type="string">修改</th>
          </tr>
        </thead>
        <tbody>

          <?
$nowUserArray=$database->select("user",["number","user","number","password","type","name","phone","payment_method"],[]);
foreach($nowUserArray as $nowUser){
    if($_GET['type'] && $_GET['type'] != $nowUser["type"]) {
        continue;
    }
    ?>
            <tr>
              <td>
                <?echo $nowUser["user"];?>
              </td>
              <td>
                <?echo $nowUser["number"];?>
              </td>
              <td>
                <?echo $nowUser["name"];?>
              </td>
              <td>
                <?echo $nowUser["phone"];?>
              </td>
              <td>
                <?
    if($nowUser["type"] == 1) {
        echo "员工";
    }
    else if($nowUser["type"] == 2) {
        echo "委托员工";
    }
    else if($nowUser['type'] == 4) {
        echo "小时工";
    }
    else if($nowUser["type"] == 3) {
        echo "管理员";
    }
    ?>
              </td>
              <td width="20%">
                <a class="btn-floating waves-effect waves-light brown lighten-2 <? if ($_COOKIE['loginUser']==$nowUser["user"]) echo " disabled ";?>" id="edit" onClick="onEditClass(<?echo $nowUser["user"];?>,'<?echo $nowUser["name"];?>');"><i class="material-icons">business</i></a>
                <a class="btn-floating waves-effect waves-light cyan  <? if ($_COOKIE['loginUser']==$nowUser["user"]) echo " disabled ";?>" id="edit" onClick="onEditSubject(<?echo $nowUser["user"];?>,'<?echo $nowUser["name"];?>');"><i class="material-icons">class</i></a>
                <a class="btn-floating waves-effect waves-light green darken-2 <? if ($_COOKIE['loginUser']==$nowUser["user"]) echo " disabled ";?>" id="edit" onClick="onEdit(<?echo $nowUser["number"];?>,<?echo $nowUser["user"];?>,<?echo $nowUser["type"];?>,'<?echo $nowUser["name"];?>','<?echo $nowUser["password"];?>','<?echo $nowUser["phone"];?>');"><i class="material-icons">mode_edit</i></a>
                <a class="btn-floating waves-effect waves-light pink darken-2 <? if ($_COOKIE['loginUser']==$nowUser["user"]) echo " disabled ";?>" id="edit" onClick="onDimiss(<?echo $nowUser["number"];?>,<?echo $nowUser["user"];?>);"><i class="material-icons">track_changes</i></a>
              </td>
            </tr>
            <?}?>
        </tbody>
      </table>
      <!-- Edit Modal Structure -->
      <div id="modalEdit" class="modal modal-fixed-footer">
        <div class="modal-content">
          <h4 class="center">修改用户</h4>
          <div class="row">
            <form class="col s10 offset-s1">
              <div class="row">
                <div class="input-field col s12">
                  <input disabled value="0" id="Edit_Num" type="text" class="validate">
                  <label for="Edit_Num">工号</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input disabled value="0" id="Edit_User" type="text" class="validate">
                  <label for="Edit_User">账号</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="Edit_Name" type="text" class="validate" value="NULL">
                  <label for="Edit_Name">用户名</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="Edit_Password" type="text" class="validate" value="NULL">
                  <label for="Edit_Password">密码</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="Edit_Phone" type="text" class="validate" value="0">
                  <label for="Edit_Phone">联系电话</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <select id="Edit_Type">
                    <option value="" disabled selected>请选择一项</option>
                    <option value="1">员工</option>
                    <option value="2">委托员工</option>
                    <option value="4">小时工</option>
                    <? //<option value="3">管理员</option> ?>
                  </select>
                  <label>类型</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <select id="Edit_Pay" type="text" class="validate" value="">
                    <option value="" disabled selected>请选择一项</option>
                    <option value="pickup">现金</option>
                    <option value="deposit">存款</option>
                    <option value="mail">邮寄</option>
                  </select>
                  <label for="Edit_Pay">薪水支付方式</label>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">返回</a>
          <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" onClick="editSubject();">确定</a>
          <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat tooltipped" onClick="deleteSubject();" data-position="bottom" data-delay="50" data-tooltip="请三思而后行！">删除</a>
        </div>
      </div>
      <div id="modalSubject" class="modal modal-fixed-footer">
        <div class="modal-content">
          <h4 id="SB_Title" class="center">Edit Subject For ???</h4>
          <div class="row">
            <form class="col s10 offset-s1">
              <div class="input-field col s12">
                <input disabled value="0" id="SB_User" type="text" class="validate">
                <label for="SB_User">账号</label>
              </div>
              <div class="input-field col s12">
                <?
$nowSubjectArray=$database->select("subject",["id","name"],[]);
foreach($nowSubjectArray as $nowSubject){
                ?>
                  <p>
                    <input type="checkbox" checked="checked" id="Subject-<?echo $nowSubject["id"];?>" />
                    <label for="<?echo 'Subject-'.$nowSubject["id"];?>">
                      <?echo $nowSubject["name"];?>
                    </label>
                  </p>
                  <?
}
?>
              </div>
            </form>
          </div>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" onClick='window.location.href="";'>返回</a>
          <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" onClick="editBelongSubject();">确定</a>
        </div>
      </div>
      <div id="vKanBuDao" class="modal">
        <h4 id="quanjubianliang">kanbudao</h4>
      </div>
      <!-- Edit Modal Structure -->
      <div id="modalClass" class="modal modal-fixed-footer">
        <div class="modal-content">
          <h4 id="CL_Title" class="center">Edit Class For ???</h4>
          <div class="row">
            <form class="col s10 offset-s1">
              <div class="input-field col s12">
                <input disabled value="0" id="CL_User" type="text" class="validate">
                <label for="CL_User">账号</label>
              </div>
              <div class="input-field col s12">
                <?
$nowSubjectArray=$database->select("class",["id","name"],[]);
foreach($nowSubjectArray as $nowSubject){
    ?>
                  <p>
                    <input type="checkbox" checked="checked" id="Class-<?echo $nowSubject["id"];?>" />
                    <label for="<?echo 'Class-'.$nowSubject["id"];?>">
                      <?echo $nowSubject["name"];?>
                    </label>
                  </p>
                  <?
}
?>
              </div>
            </form>
          </div>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" onClick='window.location.href="";'>返回</a>
          <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" onClick="editBelongClass();">确定</a>
        </div>
      </div>

      <!-- Modal Trigger -->
      <div class="fixed-action-btn" style="bottom: 48px; right: 24px;">
        <a href="#" data-activates="slide-out" class="button-collapse top-nav full modal-trigger btn-floating btn-large waves-effect waves-light orange"><i class="material-icons">menu</i></a>
      </div>
      <div class="fixed-action-btn" style="bottom: 192px; right: 24px;">
        <a class="modal-trigger btn-floating btn-large waves-effect waves-light light-blue" href="#modalNew"><i class="material-icons">add</i></a>
      </div>
      <div class="fixed-action-btn horizontal" style="bottom: 120px; right: 24px;">
        <a class="btn-floating btn-large red">
          <i class="large material-icons">search</i>
        </a>
        <ul>
          <li><a href="user.php?type=3" class="btn-floating red"><i class="material-icons">supervisor_account</i></a></li>
          <li><a href="user.php?type=2" class="btn-floating yellow darken-1"><i class="material-icons">record_voice_over</i></a></li>
          <li><a href="user.php?type=1" class="btn-floating green"><i class="material-icons">face</i></a></li>
          <li><a href="user.php" class="btn-floating cyan darken-4"><i class="material-icons">list</i></a></li>
        </ul>
      </div>
    </div>
      <!-- Edit Modal Structure -->
      <div id="modalNew" class="modal modal-fixed-footer">
        <div class="modal-content">
          <h4 class="center">新建用户</h4>
          <div class="row">
            <form class="col s10 offset-s1">
              <div class="row">
                <div class="input-field col s12">
                  <select id="New_Type">
                    <option value="" disabled selected>请选择一项</option>
                    <option value="1">员工</option>
                    <option value="4">小时工</option>
                    <option value="2">委托员工</option>
                  </select>
                  <label>类型</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input value="Unknown" id="New_User" type="text" class="validate">
                  <label for="New_User">账号</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="New_Name" type="text" class="validate" value="">
                  <label for="New_Name">姓名</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="New_Password" type="text" class="validate" value="">
                  <label for="New_Password">密码</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <select id="New_Pay" type="text" class="validate" value="">
                    <option value="" disabled selected>请选择一项</option>
                    <option value="pickup">现金</option>
                    <option value="deposit">存款</option>
                    <option value="mail">邮寄</option>
                  </select>
                  <label for="New_Pay">薪水支付方式</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="New_salary" type="text" class="validate" value="">
                  <label id="LNew_salary">(员工)薪水</label>
                </div>
              </div> 
              <div class="row">
                <div class="input-field col s12">
                  <input id="New_hour" type="text" class="validate" value="">
                  <label id="LNew_hour">(小时工)时薪</label>
                </div>
              </div> 
              <div class="row">
                <div class="input-field col s12">
                  <input id="New_comRate" type="text" class="validate" value="">
                  <label id="LNew_comRate">(提成员工)提成比例</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="New_ssn" type="text" class="validate" value="">
                  <label for="New_ssn">身份证</label>
                </div>
              </div>  
              <div class="row">
                <div class="input-field col s12">
                  <input id="New_mail" type="text" class="validate" value="">
                  <label for="New_mail">收件地址</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="New_tax" type="text" class="validate" value="">
                  <label for="New_tax">标准减税</label>
                </div>
              </div>

              <div class="row">
                <div class="input-field col s12">
                  <input id="New_otherDe" type="text" class="validate" value="">
                  <label for="New_otherDe">其它扣款</label>
                </div>
              </div>

              <div class="row">
                <div class="input-field col s12">
                  <input id="New_Phone" type="text" class="validate" value="">
                  <label for="New_Phone">联系电话</label>
                </div>
              </div>   

              <div class="row">
                <div class="input-field col s12">
                  <select id="New_limit">
                    <option value="" disabled selected>请选择一项</option>
                    <option value="1">允许</option>
                    <option value="0">不允许</option>
                  </select>
                  <label>工作时长限制</label>
                </div>
              </div>

            </form>
          </div>
        </div>
        <div class="modal-footer">
          <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">返回</a>
          <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" onClick="newUser();">新建</a>
        </div>
      </div>

      <div id="settings" class="modal">
        <div class="modal-content">
          <h4 class="center">设置</h4>
          <div class="row">
            <form class="col s10 offset-s1">
				<div class="row">
					<div class="col s8">
						<p>允许学生自由选课</p>
					</div>
						<div class="switch">
							<label>
							不允许
							<input id="selectCourse" type="checkbox" <?
							if($selectOK)
								echo 'checked="checked"';
							?>>
							<span class="lever"></span>
							允许
							</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col s7 offset-s1">
					<p>当前缓存文件大小：<?
					unset($output);
					$ret = exec("du -sbch /var/www/html/Grade/log | awk '{print $1}'", $output, $var);
					echo $output[0];
					?></p>
					</div>
					<a class="waves-effect waves-light btn" onClick="clearLog()">删除缓存文件</a>
				</div>
            </form>
          </div>
        </div>
      </div>
      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="../asset/js/jquery.js"></script>
      <script type="text/javascript" src="../asset/materialize/js/materialize.min.js"></script>
      <!--Sort function starts-->
      <script type="text/javascript">
        $(function() {
          var tableObject = $('#haowan'); //获取id为tableSort的table对象
          var tbHead = tableObject.children('thead'); //获取table对象下的thead
          var tbHeadTh = tbHead.find('tr th'); //获取thead下的tr下的th
          var tbBody = tableObject.children('tbody'); //获取table对象下的tbody
          var tbBodyTr = tbBody.find('tr'); //获取tbody下的tr

          var sortIndex = -1;

          tbHeadTh.each(function() { //遍历thead的tr下的th
            var thisIndex = tbHeadTh.index($(this)); //获取th所在的列号
            //给表态th增加鼠标位于上方时发生的事件
            $(this).mouseover(function() {
              tbBodyTr.each(function() { //编列tbody下的tr
                var tds = $(this).find("td"); //获取列号为参数index的td对象集合
                $(tds[thisIndex]).addClass("hover"); //给列号为参数index的td对象添加样式
              });
            }).mouseout(function() { //给表头th增加鼠标离开时的事件
              tbBodyTr.each(function() {
                var tds = $(this).find("td");
                $(tds[thisIndex]).removeClass("hover"); //鼠标离开时移除td对象上的样式
              });
            });

            $(this).click(function() { //给当前表头th增加点击事件
              var dataType = $(this).attr("type"); //点击时获取当前th的type属性值
              checkColumnValue(thisIndex, dataType);
            });
          });

          $("tbody tr").removeClass(); //先移除tbody下tr的所有css类
          //table中tbody中tr鼠标位于上面时添加颜色,离开时移除颜色
          $("tbody tr").mouseover(function() {
            $(this).addClass("hover");
          }).mouseout(function() {
            $(this).removeClass("hover");
          });

          //对表格排序
          function checkColumnValue(index, type) {
            var trsValue = new Array();

            tbBodyTr.each(function() {
              var tds = $(this).find('td');
              //获取行号为index列的某一行的单元格内容与该单元格所在行的行内容添加到数组trsValue中
              trsValue.push(type + ".separator" + $(tds[index]).html() + ".separator" + $(this).html());
              $(this).html("");
            });

            var len = trsValue.length;

            if (index == sortIndex) {
              //如果已经排序了则直接倒序
              trsValue.reverse();
            } else {
              for (var i = 0; i < len; i++) {
                //split() 方法用于把一个字符串分割成字符串数组
                //获取每行分割后数组的第一个值,即此列的数组类型,定义了字符串\数字\Ip
                type = trsValue[i].split(".separator")[0];
                for (var j = i + 1; j < len; j++) {
                  //获取每行分割后数组的第二个值,即文本值
                  value1 = trsValue[i].split(".separator")[1];
                  //获取下一行分割后数组的第二个值,即文本值
                  value2 = trsValue[j].split(".separator")[1];
                  //接下来是数字\字符串等的比较
                  if (type == "number") {
                    value1 = value1 == "" ? 0 : value1;
                    value2 = value2 == "" ? 0 : value2;
                    if (parseFloat(value1) > parseFloat(value2)) {
                      var temp = trsValue[j];
                      trsValue[j] = trsValue[i];
                      trsValue[i] = temp;
                    }
                  } else if (type == "ip") {
                    if (ip2int(value1) > ip2int(value2)) {
                      var temp = trsValue[j];
                      trsValue[j] = trsValue[i];
                      trsValue[i] = temp;
                    }
                  } else {
                    if (value1.localeCompare(value2) > 0) { //该方法不兼容谷歌浏览器
                      var temp = trsValue[j];
                      trsValue[j] = trsValue[i];
                      trsValue[i] = temp;
                    }
                  }
                }
              }
            }

            for (var i = 0; i < len; i++) {
              $("tbody tr:eq(" + i + ")").html(trsValue[i].split(".separator")[2]);
            }

            sortIndex = index;
          }

          //IP转成整型
          function ip2int(ip) {
            var num = 0;
            ip = ip.split(".");
            num = Number(ip[0]) * 256 * 256 * 256 + Number(ip[1]) * 256 * 256 + Number(ip[2]) * 256 + Number(ip[3]);
            return num;
          }

        })
      </script>
      <!--Sort function ends-->


      <script type="text/javascript">
        $(document).ready(function() {
          // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
          $(".button-collapse").sideNav();
          $('.modal').modal();
          $("#New_hour").hide();
          $("#New_salary").hide();
          $("#New_comRate").hide();
          $("#LNew_salary").hide();
          $("#LNew_hour").hide();
          $("#LNew_comRate").hide();
          $("#New_Type").change(function(){
              var p1=$(this).children('option:selected').val();
              if(p1==1){
                $("#New_salary").show();
                $("#LNew_salary").show();
                $("#New_comRate").hide(); 
                $("#LNew_comRate").hide();
                $("#New_hour").hide();
                $("#LNew_hour").hide();
              }
              else if(p1==2){
                $("#New_comRate").show(); 
                $("#LNew_comRate").show();
                $("#New_salary").show();
                $("#LNew_salary").show();
                $("#New_hour").hide();
                $("#LNew_hour").hide();
              }
              else if(p1==4){
                $("#New_hour").show();
                $("#LNew_hour").show();
                $("#New_comRate").hide(); 
                $("#LNew_comRate").hide();
                $("#New_salary").hide();
                $("#LNew_salary").hide();
              }
          });
          $('select').material_select();
        });

		    $("#selectCourse").change(function() {
			    if ($("#selectCourse").is(':checked')) {
    				onEditSelectSB(1);
    		  }
    		  else {
    				onEditSelectSB(0);
    			}
		    });
        function onDimiss($num, $user){
          $.post("_editDimission.php", {
              "user": $user
            },
            function(data, status) {
              //alert(data);
              if(data>0) Materialize.toast('标记离职.', 1000);
              else Materialize.toast('解除离职.', 1000);
            });
        }
        function onEdit($num, $user, $type, $name, $password, $phone) {
          $("#Edit_Num").val($num);
          $("#Edit_User").val($user);
          $("#Edit_Type").val($type);
          $("#Edit_Name").val($name);
          $("#Edit_Password").val($password);
          $("#Edit_Phone").val($phone);
         // $("#Edit_Pay").val($pay_method);
          $("#modalEdit").modal("open");
        }

        function showSettings() {
          $("#settings").modal("open");
        } 

    		function clearLog() {
    			$.post("_clearLog.php", 
    			{
    				"clear": 1
    			}, function(data, status) {
    				Materialize.toast('已删除缓存文件。', 1000);
    			});
    		}

        function onEditSubject($user, $name) {
          $.post("_belSubject.php", {
              "user": $user
            },
            function(data, status) {
              JSON.parse(data, function(k, v) {
                //console.log(k);
                //console.log(v);
                if (v == 0) {
                  //$(k).removeAttr("checked");
                  $(k).attr("checked", false);
                } else {
                  $(k).attr("checked", true);
                }

              });
              $("#SB_User").val($user);
              $("#SB_Title").text($name);
              $("#modalSubject").modal("open");
            });
        }

        function editBelongSubject() {
          $.post("_belSubjectEdit.php", { <?
              $nowSubjectArray = $database -> select("subject", ["id"], []);
              foreach($nowSubjectArray as $nowSubject)
              echo "\"Subject-".$nowSubject['id'].
              "\":$(\"#Subject-".$nowSubject['id'].
              "\").is(\":checked\"),";
              echo "\"user\":\$(\"#SB_User\").val()"; ?>
            },
            function(data, status) {
              //alert(data);
              Materialize.toast('Requested.', 1000);
              window.location.href = "";
            });
        }

        function onEditClass($user, $name) {
          $.post("_belUser.php", {
              "user": $user
            },
            function(data, status) {
              document.getElementById("quanjubianliang").val = data;
              //alert(data);
              //$("#quanjubianliang").val(1);
            });
          $.post("_belClass.php", {
              "user": $user
            },
            function(data, status) {
              JSON.parse(data, function(k, v) {
                //console.log(k);
                //console.log(v);
                if (v == 0) {
                  //$(k).removeAttr("checked");
                  $(k).attr("checked", false);
                } else {
                  $(k).attr("checked", true);
                }

              });
              $("#CL_User").val($user);
              $("#CL_Title").text($name);
              $("#modalClass").modal("open");
            });
        }

        function editBelongClass() {
          var sum = 0; <?
          $nowSubjectArray = $database -> select("class", ["id"], []);
          foreach($nowSubjectArray as $nowSubject)
          echo "if ($(\"#Class-".$nowSubject['id'].
          "\").is(\":checked\")) sum++;"; ?>
          if (sum > 1 && document.getElementById("quanjubianliang").val == 1) {
            Materialize.toast('Number Class Limited Error.', 1000);
            return;
          }
          $.post("_belClassEdit.php", { <?

              foreach($nowSubjectArray as $nowSubject)
              echo "\"Class-".$nowSubject['id'].
              "\":$(\"#Class-".$nowSubject['id'].
              "\").is(\":checked\"),";
              echo "\"user\":\$(\"#CL_User\").val()"; ?>
            },
            function(data, status) {
              //alert(data);
              Materialize.toast('Requested.', 1000);
              window.location.href = "";
            });
        }

        function onEditSelectSB($val) {
          $.post("_selectSB.php", {
              "val": $val
            },
            function(data, status) {
              if (data > 0) {
                Materialize.toast('Accepted.', 1000);
                //window.location.href = "";
              } else {
                Materialize.toast('Error.', 1000);
              }
            });
        }

        function editSubject() {
          $.post("_user.php", {
              "user": $("#Edit_User").val(),
              "password": $("#Edit_Password").val(),
              "name": $("#Edit_Name").val(),
              "type": $("#Edit_Type").val(),
              "phone": $("#Edit_Phone").val(),
              "pay_method": $("#Edit_Pay").val(),
              "Etype": 1
            },
            function(data, status) {
              //alert(data);
              if (data == 0) {
                Materialize.toast('No Edition.', 1000);
              } else if (data > 0) {
                Materialize.toast('Edited.', 1000);
                window.location.href = "";
              } else {
                Materialize.toast('Error.', 1000);
              }
            });
        }

        function newUser() {
          
          $.post("_user.php", {
              "user": $("#New_User").val(),
              "password": $("#New_Password").val(),
              "name": $("#New_Name").val(),
              "type": $("#New_Type").val(),
              "phone": $("#New_Phone").val(),

              "mails": $("#New_mail").val(),
              "tax_deductions": $("#New_tax").val(),
              "other_deductions": $("#New_otherDe").val(),
              "hourly_rate": $("#New_hour").val(),
              "salary": $("#New_salary").val(),
              "com_rate": $("#New_comRate").val(),  
              "hour_limit": $("#New_limit").val(),  
              "pay_method": $("#New_Pay").val(),
              "Etype": 2
            },
            function(data, status) {
              //alert(data);
              if (data > 0) {
                Materialize.toast('Requested.', 1000);
                window.location.href = "";

              } else {
                Materialize.toast('Creat fail.', 1000);
                window.location.href = "";
              }
            });

        }

        function deleteSubject() {
          $.post("_user.php", {
              "user": $("#Edit_User").val(),
              "password": $("#Edit_Password").val(),
              "name": $("#Edit_Name").val(),
              "type": $("#Edit_Type").val(),
              "phone": $("#Edit_Phone").val(),
              "Etype": 3
            },
            function(data, status) {
              if (data > 0) {
                Materialize.toast('Deleted.', 1000);
                window.location.href = "";
              } else {
                Materialize.toast('Error.', 1000);
              }
            });
        }

        function delAllCookie() {
          $.post("../login/loginLib.php", {
              "logout": true
            },
            function(data, status) {
              window.location.href = "";
            });
        }
      </script>
  </body>

  </html>

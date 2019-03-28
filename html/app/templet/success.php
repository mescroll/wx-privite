<?php
	$w_openid = $_GET['openid'];
	$task_num = $_GET['orderNum'];
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>订单详情</title>
		<link rel="stylesheet" type="text/css" href="https://cdn.bootcss.com/weui/1.1.3/style/weui.min.css"/>
		<link rel="stylesheet" type="text/css" href="https://cdn.bootcss.com/jquery-weui/1.2.1/css/jquery-weui.min.css"/>
		<link rel="stylesheet" type="text/css" href="https://flyingman.sc2yun.com/lib/js/layer/mobile/need/layer.css"/>
	</head>
	<style type="text/css">
		*{
			margin: 0;
			padding: 0;
		}
		body{
			background-color: #F5F6F5;
			font-family: "宋体";
		}
		.worker{
			display: -webkit-flex;/* safari浏览器 */
			display: flex;
			flex-direction: column;/* 垂直排列 */
			background-color: #FFFFFF;
			margin-top: 0.1em;
		}
		.worker-top{
			display: -webkit-flex;
			display: flex;
			align-items: center;/* 项目居中 */
			flex-direction: row;
		}
		.worker-top-left{
			margin-left: 1rem;
			width: 20%;
		}
		.worker-top-right{
			margin-left: 1.5em;
			width: 80%;
		}
		.worker-header img{
			border-radius: 50%;
			border: 3px solid #DCDCDC;
			overflow: hidden;
			margin-top: 0.5em;
			height: 3.5em;
		}
		.worker-down{
			border-top: 1px solid #DCDCDC;
			display: -webkit-flex;
			display: flex;
			align-items: center;
			flex-direction: row;
		}
		.foot-left{
			display: -webkit-flex;
			display: flex;
			align-items: center;
			flex-direction: column;
			border-right: 1px solid #DCDCDC;
			width: 50%;
		}
		.foot-right{
			display: -webkit-flex;
			display: flex;
			align-items: center;
			flex-direction: column;
			width:50%;
		}
		.foot-left-info p{
			color: #1296DB;
		}
		
		ul li{
			list-style: none;
			display: inline-block;
		}
		ul li img{
			height: 1em;
		}
		.weui-cell img{
			height: 1.75em;
		}
		.btn{
			margin-top: 2em;
		}
		
	</style>
	<body>
		<!-- 个人信息栏 -->
		<div class="worker">
			<div class="worker-top">			
				<!-- 头像部分 -->
				<div class="worker-header worker-top-left">
					<img id="head" src="https://flyingman.sc2yun.com/images/templet/lazeload.jpg" >
				</div>
				<!-- 名字和手机号 -->
				<div class="worker-info worker-top-right">
					<!-- 名字 -->
					<div class="worker-name">
						<p id="name">小飞侠</p>
					</div>
					<!-- 手机号 -->
					<div class="worker-tel">
						<p id="tel">暂无手机号</p>
					</div>
				</div>
			</div>
			<!-- 底栏-服务人数和好评率 -->
			<div class="worker-down">
				<!-- 完成订单数 -->
				<div class="foot-left">
					<div class="foot-left-text">
						<p>已完成订单数</p>
					</div>
					<!-- 完成订单数字展示 -->
					<div class="foot-left-info">
						<p class="worker-foot-info-con" id="task-con">暂无</p>
					</div>
				</div>
				<!-- 好评率 -->
				<div class="foot-right">
					<div class="foot-right-text">
						<p>好评率</p>						
					</div>
					<!-- 好评率星星展示 -->
					<div class="foot-right-info">
						<ul class="star">
							<li><img id="star-1" src="https://flyingman.sc2yun.com/images/templet/star_3.png" ></li>
							<li><img id="star-2" src="https://flyingman.sc2yun.com/images/templet/star_3.png" ></li>
							<li><img id="star-3" src="https://flyingman.sc2yun.com/images/templet/star_3.png" ></li>
							<li><img id="star-4" src="https://flyingman.sc2yun.com/images/templet/star_3.png" ></li>
							<li><img id="star-5" src="https://flyingman.sc2yun.com/images/templet/star_3.png" ></li>
						</ul>
					</div>
				</div>				
			</div>
		</div>
		<!-- 任务描述 -->
		<div class="weui-cells">
		  <div class="weui-cell">
			<div class="weui-cell__hd"><img src="https://flyingman.sc2yun.com/images/templet/date2.png"></div>
			<div class="weui-cell__bd">
			  <p>领取时间</p>
			</div>
			<div class="weui-cell__ft" id="task-time"></div>
		  </div>
		  <div class="weui-cell">
			<div class="weui-cell__hd"><img src="https://flyingman.sc2yun.com/images/templet/date1.png"></div>
			<div class="weui-cell__bd">
			  <p>截止时间</p>
			</div>
			<div class="weui-cell__ft" id="task-limit"></div>
		  </div>
		  <div class="weui-cell">
		  <div class="weui-cell__hd"><img src="https://flyingman.sc2yun.com/images/templet/tasklist.png"></div>
		  <div class="weui-cell__bd">
		  	<p>任务类型</p>
		  </div>
		  <div class="weui-cell__ft" id="task-type"></div>
		  </div>
		  <div class="weui-cell">
		  <div class="weui-cell__hd"><img src="https://flyingman.sc2yun.com/images/templet/money.png"></div>
		  <div class="weui-cell__bd">
		  	<p>酬金</p>
		  </div>
		  <div class="weui-cell__ft" id="money"></div>
		  </div>
		</div>
		<div class="weui-cells">
		  <a class="weui-cell weui-cell_access"id="btn-police">
			<div class="weui-cell__hd"><img src="https://flyingman.sc2yun.com/images/templet/police.png"></div>
			<div class="weui-cell__bd">
			<p>一键投诉</p>
			</div>
			<div class="weui-cell__ft"></div>
		  </a>
		</div>
		<a href="javascript:;" class="weui-btn weui-btn_primary btn" id="btn-ok">确认收货</a>
		<div class="weui-footer weui-footer_fixed-bottom">
		  <p class="weui-footer__text">校园飞侠 © 2018 v0.1.3</p>
		</div>
	</body>
	<script src="https://libs.baidu.com/jquery/2.0.0/jquery.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="https://cdn.bootcss.com/jquery-weui/1.2.1/js/jquery-weui.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		$().ready(function(){
			$.support.cors = true;
			$.ajax({
				// 用来获取抢单人的头像和手机号,姓名,信用分,历史订单数
				type:'post',
				url:'https://flyingman.sc2yun.com/php_unit_public/app/page/templet/success.php',
				dataType:'json',
				data:{
					w_openid:'<?php echo $w_openid; ?>'
				},
				success:function(e){
					// 如果获取抢单人信息成功,再获取订单信息
					//异步执行,请求数据时继续执行head部分赋值
					var order_num = '<?php echo $task_num; ?>';
					$.ajax({
						type:'post',
						url:'https://flyingman.sc2yun.com/php_unit_public/app/page/templet/successTask.php',
						dataType:'json',
						data:{
							task_num:order_num
						},
						success:function(d){
							var xhr = eval(d);
							//将task_flag,订单号保存到cookie
							document.cookie="task_flag="+xhr.task_flag;
							
							var now_time = new Date(xhr.time_now * 1000).toLocaleString('chinese',{hour12:false}).replace(/\/{1}/,'年').replace(/:\d{1,2}$/,' ').replace(/\/{1}/,'月').replace(/ {1}/,'日 ');
							var time_limit = new Date(xhr.time_limit * 1000).toLocaleString('chinese',{hour12:false}).replace(/\/{1}/,'年').replace(/:\d{1,2}$/,' ').replace(/\/{1}/,'月').replace(/ {1}/,'日 ');
							$('#task-time').html(now_time);
							$('#task-limit').html(time_limit);
							$('#task-type').html(xhr.task_type);
							$('#money').html(xhr.money);														
						},
						error:function(jqXHR,textStatus,errorThrown){
							console.log(jqXHR);
							console.log(textStatus);
							console.log(errorThrown);
							$.toptip("服务器有点小问题，抓取数据失败","error");
						}
					});
					var rtnData = eval(e);
					console.log(rtnData);
					$('#head').attr("src",rtnData.headimg);
					$('#name').html(rtnData.nick);
					$('#tel').html(rtnData.tel);
					$('#task-con').html(rtnData.task_old);
					document.cookie="task_old="+rtnData.task_old;
					var num = rtnData.score;
					if(num>=80 && num<100){
						$('#star-5').attr("src",'https://flyingman.sc2yun.com/images/templet/star_2.png');
					}else if(num<80 && num >=60){
						$('#star-5').attr("src",'https://flyingman.sc2yun.com/images/templet/star_1.png');
						$('#star-4').attr("src",'https://flyingman.sc2yun.com/images/templet/star_2.png');
					}else if(num <60 && num >= 40){
						$('#star-5').attr("src",'https://flyingman.sc2yun.com/images/templet/star_1.png');
						$('#star-4').attr("src",'https://flyingman.sc2yun.com/images/templet/star_1.png');
						$('#star-3').attr("src",'https://flyingman.sc2yun.com/images/templet/star_2.png');
					}else if(num <40 && num>= 20){
						$('#star-5').attr("src",'https://flyingman.sc2yun.com/images/templet/star_1.png');
						$('#star-4').attr("src",'https://flyingman.sc2yun.com/images/templet/star_1.png');
						$('#star-3').attr("src",'https://flyingman.sc2yun.com/images/templet/star_1.png');
						$('#star-2').attr("src",'https://flyingman.sc2yun.com/images/templet/star_2.png');
					}else if(num>=10 && num<20){
						$('#star-5').attr("src",'https://flyingman.sc2yun.com/images/templet/star_1.png');
						$('#star-4').attr("src",'https://flyingman.sc2yun.com/images/templet/star_1.png');
						$('#star-3').attr("src",'https://flyingman.sc2yun.com/images/templet/star_1.png');
						$('#star-2').attr("src",'https://flyingman.sc2yun.com/images/templet/star_1.png');
						$('#star-1').attr("src",'https://flyingman.sc2yun.com/images/templet/star_2.png');
					}else if(num <10){
						$('#star-5').attr("src",'https://flyingman.sc2yun.com/images/templet/star_1.png');
						$('#star-4').attr("src",'https://flyingman.sc2yun.com/images/templet/star_1.png');
						$('#star-3').attr("src",'https://flyingman.sc2yun.com/images/templet/star_1.png');
						$('#star-2').attr("src",'https://flyingman.sc2yun.com/images/templet/star_1.png');
						$('#star-1').attr("src",'https://flyingman.sc2yun.com/images/templet/star_1.png');
					}
					
				},
				error:function(jqXHR,textStatus,errorThrown){
					console.log(jqXHR);
					console.log(textStatus);
					console.log(errorThrown);
					$.toptip("服务器拥挤，请稍后再试~","error");
				}
			})
		});
						
	</script>
	<script src="https://flyingman.sc2yun.com/lib/js/layer/mobile/layer.js" type="text/javascript" charset="utf-8"></script>
</html>
<script type="text/javascript">
	$('#btn-police').click(function(){
		
		$.prompt({
		  title: '投诉',
		  text: '请告诉我们简要投诉原因，客服同学将会在两个工作日内联系您',
		  input: '时间拖延',
		  empty: false, // 是否允许为空
		  onOK: function (input) {
			//投诉内容处理,将订单号从session取出来
			$.support.cors = true;
			$.ajax({
				type:'post',
				url:'https://flyingman.sc2yun.com/php_unit_public/app/page/templet/email.php',
				dataType:'json',
				data:{
					orderNum:'<?php echo $task_num;?>',
					text:input
				},
				success:function(e){
					$.toptip("投诉成功！","success");
				},
				error:function(jqXHR,textStatus,errorThrown){
					console.log(jqXHR);
					console.log(textStatus);
					console.log(errorThrown);
					$.toptip("网络错误，请稍后再试");
				}
			})
		  },
		  onCancel: function () {
			//点击取消
		  }
		});
	})
	//确认收货提交
	$('#btn-ok').click(function(){
		$.support.cors = true;
		//检查是否已经提交,刚才已经将task_flag保存到cookie了
		var flag = get_cookie("task_flag");
		var task_old = get_cookie("task_old");
		console.log(flag);
		if(flag == 1){
			$.toptip("当前任务已结单，不可重复收货哦","warning");
		}else{
			$.confirm({
			title: '确认收货',
			text: '您确定任务已经完成了吗，提交后将无法修改哦',
			onOK: function () {
				//点击确认,将订单号从seession取出来
				$.ajax({
					type:'post',
					url:'https://flyingman.sc2yun.com/php_unit_public/app/page/templet/taskOver.php',
					dataType:'json',
					data:{
						orderNum:'<?php echo $task_num ?>',
						w_openid:'<?php echo $w_openid ?>',
						task_old:task_old
					},
					success:function(e){
						var xhr = JSON.parse(e);
						console.log(xhr);
						if(xhr == 1){
							$.toptip("收货完成","success");
							//重置页面
							del_cookie("task_flag");
							del_cookie("task_old");
							window.setTimeout(function(){
								window.location.reload();
							},2000);														
						}else{
							$.toptip("收货失败，请稍后再试");
						}
					},
					error:function(jqXHR,textStatus,errorThrown){
						console.log(jqXHR);
						console.log(textStatus);
						console.log(errorThrown);
						$.toptip("服务器繁忙，请稍后再试");
					}
				})
			},
			onCancel: function () {
			}
			});
		}		
	})
	//读取cookie
	function get_cookie(Name) {
	var search = Name + "="//查询检索的值
	var returnvalue = "";//返回值
	if (document.cookie.length > 0) {
		sd = document.cookie.indexOf(search);
		if (sd!= -1) {
			sd += search.length;
			end = document.cookie.indexOf(";", sd);
			if (end == -1)
			end = document.cookie.length;
			//unescape() 函数可对通过 escape() 编码的字符串进行解码。
			returnvalue=unescape(document.cookie.substring(sd, end))
		}
	} 
	return returnvalue;
	}
	//删除cookie
	function del_cookie(name){ //删除cookie方法
		var date = new Date(); //获取当前时间
		date.setTime(date.getTime()-10000); //将date设置为过去的时间
		document.cookie = name + "=v; expires =" +date.toGMTString();//设置cookie
	}
</script>
	

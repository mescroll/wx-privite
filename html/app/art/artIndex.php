<?php
require_once "/home/www/htdocs/disk/home/privite/html/app/art/jssdk.php";
$jssdk = new JSSDK("wxa507747c7a15f546", "11d3dceb35352885375d7bcc82801ed0");
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<title></title>
		<link rel="stylesheet" type="text/css" href="/html_lib/js/layer/mobile/need/layer.css"/>
		<link rel="stylesheet" type="text/css" href="/src/css/weui.min.css"/>
		<link rel="stylesheet" type="text/css" href="/public/html/css/like.css"/>
		<style>
			html,body{
				overflow:hidden;
				overflow-y:auto;
			}
		</style>
		<script src="/html_lib/js/fundebug/fundebug.1.7.3.min.js" apikey="ce564ba37992fb6460f751c554dbb79a37fb6806591f8ffe90089c446fa5a649"></script>
		<script src="https://libs.baidu.com/jquery/2.0.0/jquery.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="/public/html/js/getParam.js" type="text/javascript" charset="utf-8"></script>
		<script src="/public/html/js/getTimeForStr.js" type="text/javascript" charset="utf-8"></script>
		<script src="/html_lib/js/layer/mobile/layer.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
			var artDataType= $.Request("artDataType");
			var dataIndex = $.Request("dataIndex");
			var flag = $.Request("flag");
			var id = $.Request("id");
			console.log(dataIndex+"--"+id+" flag="+flag);
			var readCount = "";// 阅读数
			var likeCount = "";//点赞数
			$.ajax({
				type:'post',
				url:'http://xiaoyuanfeixia.com/public/app/page/art/art.php',
				dataType:'json',
				data:{
					dataIndex:dataIndex,
					id:id,
					type:artDataType
				}, 
				beforSend:function(){
					layer.open({
					type: 2,
					content: '加载中',
					shade:false
					});
				},
				success:function(e){
					var xhr = eval(e);
					document.cookie="artImageUrl="+escape(xhr.imageUrl);
					readCount = xhr.read;
					likeCount = xhr.like;
					console.log(readCount+"--"+likeCount);
					layer.closeAll();
					setList(xhr);
					//设置阅读量和点赞数
					$('#readCount').html(readCount);
					$('#likeCount1').html(likeCount);
					//设置两个页面的返回键
					if(flag == null && artDataType == 1){
						$('#back-btn').attr("onclick","backArt();");
						$('#back-btn').html("去主页浏览更多");
					}else if(flag == null && artDataType == 2){
						$('#back-btn').attr("onclick","backProse();");
						$('#back-btn').html("去主页浏览更多");
					}else{
						$('#back-btn').attr("onclick","backAfter();");						
					}					
					getData(1,readCount);					
				},
				error:function(jqXHR,textStatus,errorThrown){
					console.log(jqXHR);
					console.log(textStatus);
					console.log(errorThrown);
					layer.open({
					  content: '服务器有点忙，请稍后再试~'
					  ,time: 3
					});
				}
			})
			//返回黑科技
			function backArt(){
				window.location.href = "http://xiaoyuanfeixia.com/public/html/app/sence/article.html";
			}
			//返回小确幸
			function backProse(){
				window.location.href = "http://xiaoyuanfeixia.com/public/html/app/sence/artProse.html";
			}
			//返回上一页
			function backAfter(){
				window.history.go(-1);
			}
			function setList(xhr){
				var times = getMyDate(xhr.time*1000);
				var str ='<div class="title">';
				str += '<p id="title">'+xhr.dest+'</p>';
				str +='</div>';
				str +='<div class="connter">';
				str +='<div class="header">';
				str +='<img id="imgUrl" src="'+xhr.headUrl+'"/>';
				str +='</div>';
				str +='<div class="author">';
				str +='<div class="name">';
				str +='<span id="author" class="author-name">'+xhr.idName+'</span>';
				str +='</div>';
				str +='<div class="time">';
				str +='<span id="time" class="time-time">'+times+'</span>';
				str +='</div>';
				str +='</div>';
				str +='</div>';
				str +='<div class="ldest">';
				str +='<p id = "ldest">'+xhr.ldest+'</p>';
				str +='</div>';
				str +='<div class="text">';
				str +=xhr.artice;
				str +='</div>';
				str +='</div>';
			
			var liDom=document.createElement("abc");
			liDom.innerHTML=str;
			$('#art').append(liDom);	
		}
		//读取cookie函数
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
	
		</script>
	</head>
	<style type="text/css">
		*{
			margin: 0;
			padding: 0;
		}
		body{
			margin-left: 0.5em;
			margin-right: 0.5em;
		}
		.nav{
			background-color: #F2F2F2;
			width: 100%;
			height: 2em;
		}
		.nav img{
			margin-top: 0.25em;
			height: 1.5em;
		}
		.title{
			font-size: 1.8em;
		}
		.connter{
			display: flex;
			margin-top: 1em;
			height: 4em;
		}
		.header{									
			width: 15%;
		}
		.header img{
			border-radius: 50%;
			border: 1px solid oldlace;
			overflow: hidden;
			height: 3em;
			width: 80%;
		}
		.author{
			display: flex;
			flex-direction: column;
			margin-left: 0.5em;
		}
		.author-name{
			font-size: 1.1em;
			color: 	#1C1C1C;
			letter-spacing:5px;
		}
		.time-time{
			font-size: 0.8rem;
			color: #A9A9A9;
		}
		.ldest{
			color: #A9A9A9;
			margin-bottom: 2em;
			text-indent:1em;
			font-family: "楷体";
		}
		.text{
			font-family: "微软雅黑";
		}
		.text img{
			margin-right: 0.5em;
			width: 100%;
		}
		.foot{
			display: flex;
			justify-content: flex-start;
			margin-top: 2em;
		}
		.read img{
			margin-top: 0.6em;
			height: 1.6em;
			width: 1.6em;
		}
		.btn{
			margin-top: 1.25em;
			margin-bottom: 2.5em;
		}
	</style>
	<body>
		<div id="art"></div>
		<article class="htmleaf-container">
			<div class="read">
				<img  src="http://xiaoyuanfeixia.com/images/art/eye.png" >
				<span id="readCount" class="readCount">					
				</span>
			</div>
			<div id="container">
				<div class="feed" id="feed1">	
					<div class="heart " id="like1" rel="like"></div>
					<div class="likeCount" id="likeCount1"></div>
				</div>
			</div>		
		</article>
			<a href="javascript:;" class="weui-btn weui-btn_primary btn" id="back-btn">返回上一页</a>
	<script src="http://res2.wx.qq.com/open/js/jweixin-1.4.0.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		console.log(id+"----"+dataIndex);
		wx.config({
			debug: false,
			appId: '<?php echo $signPackage["appId"];?>',
			timestamp: <?php echo $signPackage["timestamp"];?>,
			nonceStr: '<?php echo $signPackage["nonceStr"];?>',
			signature: '<?php echo $signPackage["signature"];?>',
			jsApiList: [
						"onMenuShareTimeline",
						"onMenuShareAppMessage"
			]
		});
		wx.ready(function () {
				var text = $('#title').html();
				var ldest = $('#ldest').html();
				var artImageUrl = unescape(get_cookie("artImageUrl"));
				
				var url = "http://xiaoyuanfeixia.com/public/html/app/art/artIndex.php?artDataType="+artDataType+"&id="+id+"&dataIndex="+dataIndex;
							
				var shareDateFrend = {
					title: text, // 分享标题
					desc: ldest, // 分享描述
					link: url, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
					imgUrl: artImageUrl, // 分享图标
					success: function () {
					}
				};
				wx.onMenuShareTimeline(shareDateFrend);
				wx.onMenuShareAppMessage(shareDateFrend);
		});
		wx.error(function(res){
			alert(res);
		});
		/*阅读量和点赞数获取并提交*/		
		/*dataType
		1:阅读量+1,参数为当前阅读量
		2.点赞数+1，参数为当前点赞数
		*/		
			$('body').on("click",'.heart',function(){				
				var A=$(this).attr("id");
				var B=A.split("like");
				var messageID=B[1];
				var C=parseInt($("#likeCount"+messageID).html());
				$(this).css("background-position","")
				var D=$(this).attr("rel");
				
				if(D === 'like'){
					//点赞
					getData(2,likeCount);
				$("#likeCount"+messageID).html(C+1);
				$(this).addClass("heartAnimation").attr("rel","unlike");
				}
			});	
		
			/*点赞+阅读*/
			function getData(dataType,count){
				$.ajax({
					type:'post',
					url:'http://xiaoyuanfeixia.com/public/app/page/art/like.php',
					dataType:'json',
					data:{
						artType:artDataType,
						dataType:dataType,
						dataIndex:dataIndex,
						id:id,
						count:count
					},
					success:function(e){						
					},
					error:function(jqXHR,textStatus,errorThrown){
						console.log(jqXHR);
						console.log(textStatus);
						console.log(errorThrown);					
					}
				})
			}
		
	</script>
	</body>
</html>

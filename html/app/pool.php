<?php
session_start();
$openid = $_SESSION['openid'];
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<title>全国抢单池</title>
		<link rel="stylesheet" type="text/css" href="https://cdn.bootcss.com/weui/1.1.3/style/weui.min.css"/>
		<link rel="stylesheet" type="text/css" href=" https://cdn.bootcss.com/jquery-weui/1.2.1/css/jquery-weui.min.css"/>
		<link rel="stylesheet" type="text/css" href="http://xiaoyuanfeixia.com/html_lib/css/mescroll.min.css"/>
		<link rel="stylesheet" type="text/css" href="http://xiaoyuanfeixia.com/html_lib/js/layer/mobile/need/layer.css"/>
			
		<style type="text/css">
			/*每个任务的样式*/
			.flex-board{
				border: 1px solid skyblue;
				margin-top: 1em;
				margin-bottom: 1.9em;
				background: #E7EAED;
				border-radius: 1.25em;
				box-shadow: 2px 2px 20px #808080;
			}
			/*第一行样式*/
			.flex-1{
				text-align: center;
				height: 2.3em;
			}
			.flex-1-2{
				display: none;
				color: red;
			}
			.flex-1-3{
				text-align: start;
			}
			.flex-1-3 a{
				font-size: 1rem;
				color: red;
				margin-top: 1px;
			}
			/*第二行样式*/
			.flex-2-button{
				height: 4.5em;
				width: 4.5em;
				border-radius: 25px;
				box-shadow: 0 0 10px #06c;
				background: #9999CC;
			}
			/*去掉按钮按下时的方框*/
			.flex-2-button:focus{
				outline: none;
			}
			/*第三行样式*/
			.flex-3 {
				height: 4.5em;
			}
			.flex-3 a{
				word-wrap:break-word;
			}
			/*第四行样式*/
			.flex-4 {
				height: 5em;
			}
			.flex-4 a{
				word-wrap:break-word;
			}
	</style>
	</head>

	<body>			
		<div class="weui-tab">
			<div class="weui-navbar">				
				<a  class="weui-navbar__item weui-bar__item--on"   href="#mescroll0" i="0" >
					抢单池
				</a>
				<a class="weui-navbar__item" href="#mescroll1" i="1">
					已抢任务
				</a>
			</div>	
		<!--滑动区域-->
			<div class="weui-tab__bd ">
				<!-- 抢单池页面 -->
				<div id="mescroll0" class="weui-tab__bd-item weui-tab__bd-item--active mescroll">
					<div id="dataList0"></div>
				</div>
				<!-- 已抢任务页面 -->
				<div id="mescroll1" class="weui-tab__bd-item mescroll">
					<div id="dataList1"></div>
				</div>
			</div>
		</div>
	</body>
	
	<script src="http://xiaoyuanfeixia.com/html_lib/js/mescroll.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="https://libs.baidu.com/jquery/2.0.0/jquery.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="https://cdn.bootcss.com/jquery-weui/1.2.1/js/jquery-weui.min.js" type="text/javascript" charset="utf-8"></script>
	
	
	<script type="text/javascript" charset="utf-8">
		$(function(){
			var curNavIndex=0;//抢单页0; 已抢列表1; 
			var mescrollArr=new Array(2);//2个菜单所对应的2个mescroll对象
			//初始化首页
			mescrollArr[0]=initMescroll("mescroll0", "dataList0");
			
			//初始化菜单
			$(".weui-navbar a").click(function(){
				//取出当前页的i的值
				var i = Number($(this).attr("i"));
				//console.log("  当前页的值i= "+i);
				if(curNavIndex != i){
					if(mescrollArr[i] == null){
						mescrollArr[i] = initMescroll("mescroll"+i,"dataList"+i);
					}else{
						//检查是否需要显示回到顶部按钮
						var curMescroll=mescrollArr[i];
						var curScrollTop=curMescroll.getScrollTop();
						if(curScrollTop>=curMescroll.optUp.toTop.offset){
							curMescroll.showTopBtn();
						}else{
							curMescroll.hideTopBtn();
						}
					}
					curNavIndex = i;
				}
			});
			
			
			//创建MeScroll对象,内部已默认开启下拉刷新,自动执行up.callback,重置列表数据;
			//第一个参数是上面定义的div的id,第二个参数是对刷新事件的配置		
			function initMescroll(mescrollId,clearEmptyId){
				var mescroll = new MeScroll(mescrollId, {
					//上拉加载
					up: {
						page:{
							num:0,//当前页,会自动自增,不写默认0
							size:5,//每次加载的数据条数,不写默认10
							},
						loadFull: {
							use: false, 
							delay: 200 //延时执行的毫秒数; 延时是为了保证列表数据或占位的图片都已初始化完成,且下拉刷新上拉加载中区域动画已执行完毕;
						},
						noMoreSize: 5,//如果列表已无数据,可设置列表的总数量要大于5才显示无更多数据;提高用户体验
						callback: getListData, //上拉回调,此处可简写; 相当于 callback: function (page) { getListData(page); }
						isBounce: false, //此处禁止ios回弹,解析(务必认真阅读,特别是最后一点): http://www.mescroll.com/qa.html#q10
						clearEmptyId: "dataList", //1.下拉刷新时会自动先清空此列表,再加入数据; 2.无任何数据时会在此列表自动提示空
						toTop:{ //配置回到顶部按
							src : "http://xiaoyuanfeixia.com/html_lib/res/img/mescroll-totop.png", //默认滚动到1000px显示,可配置offset修改
							offset : 300//设置滚动到500px时便显示回到顶部按钮
						},
						/**************************************************
						*此处bug：当多个tab的空逻辑展示页面是相同的，需要整改
						***************************************************/
						empty: {//列表无任何数据时,显示的空提示布局; 需配置warpId才显示						
							icon: "http://xiaoyuanfeixia.com/html_lib/res/img/mescroll-empty.png", //图标,默认null,支持网络图
							tip: "您还没抢单哦，去抢一单吧~" ,//提示
							btntext: "去抢单 >", //按钮,默认""
							btnClick: function(){//点击按钮的回调,默认null
								//alert("赶快去抢单池里赚钱吧~");
									layer.open({
									type : 1,
									adim : 'up',
									title : '快去抢单赚钱吧~',
									content : '校园飞侠 V0.1.2',
									skin : 'msg',
									style : 'border-radius:1.5em',
									time : 3
								});
							} 
						},
						clearEmptyId: clearEmptyId, //相当于同时设置了clearId和empty.warpId; 简化写法;默认null;
						htmlLoading: '<p class="upwarp-progress mescroll-rotate"></p><p class="upwarp-tip">让飞侠飞一会..</p>',
						htmlNodata: '<p class="upwarp-nodata">-- 没有更多了 --</p>',
						lazyLoad: {
							use: true, 
						}
					}
				});
				return mescroll;
			}
			
			//获取数据
			function getListData(page){
				var dataIndex=curNavIndex;//记录下标,防止快速切换时,已经变化
				var num = page.num-1;
				$.ajax({
					type : 'get',
					url :'http://xiaoyuanfeixia.com/privite/app/page/pool_data_decode.php?page='+num+'&size='+page.size+'&dataIndex='+dataIndex,
					dateType : 'json',
					success : function(curPageDateFormat){	
						var curPageDate = JSON.parse(curPageDateFormat);
						console.log("dataIndex = "+dataIndex+",page = "+num+",size = "+page.size+",length = "+curPageDate.length);
						//隐藏 下拉刷新和上拉加载的状态
						mescrollArr[dataIndex].endSuccess(curPageDate.length);
						//设置列表数据
						setListData(curPageDate,dataIndex);
						
					},
					error : function(e){
						//联网失败回调,隐藏下拉刷新和上拉加载状态
						mescrollArr[dataIndex].endErr();
					}
				});
			}
			
			/*设置列表数据*/
			function setListData(curPageData,dataIndex){
				if(dataIndex == 0){
				var listDom=document.getElementById("dataList"+dataIndex);
				for (var i = 0; i < curPageData.length; i++) {						
					var pd=curPageData[i];
					var times = new Date(pd.time_limit * 1000).toLocaleString('chinese',{hour12:false}).replace(/\/{1}/,'年').replace(/:\d{1,2}$/,' ').replace(/\/{1}/,'月').replace(/ {1}/,'日 ');
					var id = pd.id;
					
					var str='<div class="flex-board" id="first">';
					str+='<div class="weui-flex flex-1" >';
					str+='<div class="weui-flex__item"><div class="placeholder flex-1-1">'+pd.task_type+'</div></div>';
					str+='<div class="weui-flex__item"><div class="placeholder flex-1-2">'+pd.openid+'</div></div>';
					str+='<div class="weui-flex__item"><div class="placeholder flex-1-3">酬金：<a>'+pd.money+'&nbsp</a>元</div></div>';
					str+='</div>';
					
					str+='<div class="weui-flex flex-2 " id="2">';
					str+='<div class="weui-flex__item"><div class="placeholder flex-2-1"><span>任务截止时间：'+times+'</span></div></div>';
					
					str+='<div id="3">';
					str+='<input type="button" class="placeholder flex-2-button" id="'+id+'" onclick="grap_task(this.id)" value = "抢"/>';
					str+='</div>';
					
					str+='</div>';
					str+='<div class="weui-flex flex-3">';
					str+='<div class="weui-flex__item"><p class="placeholder "><a>任务简述：</a>'+pd.dest+'</p></div>';
					str+='</div>';
					str+='</div>';
					str+='<hr>';
										
					var liDom=document.createElement("abc");
					liDom.className = "abc"+pd.id;
					liDom.innerHTML=str;
					listDom.appendChild(liDom);					
				}
			}else if(dataIndex == 1){
				//设置已抢列表的页面
                    var listDom=document.getElementById("dataList"+dataIndex);
                    for (var i = 0; i < curPageData.length; i++) {
                        var pd=curPageData[i];
						console.log(pd);
                        var times = new Date(pd.time_limit * 1000).toLocaleString('chinese',{hour12:false}).replace(/\/{1}/,'年').replace(/:\d{1,2}$/,' ').replace(/\/{1}/,'月').replace(/ {1}/,'日 ');
                        var nowTime = new Date(pd.time_now * 1000).toLocaleString('chinese',{hour12:false}).replace(/\/{1}/,'年').replace(/:\d{1,2}$/,' ').replace(/\/{1}/,'月').replace(/ {1}/,'日 ');
                        if(pd.task_flag == 1){
                            var flag = "已结单";
                        }else{
                            var flag = "已抢单";
                        }
                        var str='<div class="flex-board" id="first">';

                        str+='<div class="weui-flex flex-1" >';
                        str+='<div class="weui-flex__item"><div class="placeholder flex-1-1" >'+pd.task_type+'</div></div>';
                        str+='<div class="weui-flex__item"><div class="placeholder flex-1-2" style="display: block "><a id="flag">'+flag+'</a></div></div>';
                        str+='<div class="weui-flex__item"><div class="placeholder flex-1-3">酬金：&nbsp'+pd.money+'&nbsp元</div>';
                        str+='</div></div>';

                        str+='<div class="weui-flex flex-2 " id="2">';
                        str+='<div class="weui-flex__item"><div class="placeholder flex-2-1"><span>截止时间：'+times+'</span></div></div>';
                        str+='</div>';

                        str+='<div class="weui-flex flex-2 " id="2">';
                        str+='<div class="weui-flex__item"><div class="placeholder flex-2-1"><span>领取时间：'+nowTime+'</span></div></div>';
                        str+='<div id="3">';
                        str+='<a href="javascript:;" class="weui-btn weui-btn_mini weui-btn_plain-primary" id="'+pd.id+'" onclick=dele_task(this.id)>删除</a>';
                        str+='</div>';
												str+='</div>';

                        str+='<div class="weui-flex flex-3">';
                        str+='<div class="weui-flex__item"><p class="placeholder "><a>任务简述：'+pd.dest+'</a></p> </div>';
                        str+='</div>';

                        str+='<div class="weui-flex flex-4">';
                        str+='<div class="weui-flex__item"><p class="placeholder "><a>详细简述：'+pd.ldest+'</a></p> </div>';
                        str+='</div>';

                        str+='</div>';

                        var liDom=document.createElement("shi");
												liDom.className = "shi"+pd.id;
                        liDom.innerHTML=str;
                        listDom.appendChild(liDom);
                    }
				}
			}
		
				//抢单成功提示
				function successTips(){
					layer.open({
						adim : 'up',
						content : '恭喜，抢单成功',
						style: 'border: 2px solid skyblue; background-color:#FFFAE8; color:#249FB9;',
						time : 2
					});
				}	
				//任务被抢提示
				function repTips(){
					layer.open({
						admin : 'up',
						content : '任务已经被抢了哦',
						style: 'border: 1px solid skyblue; background-color:#FFFAE8; color:red;',
						time : 2
					});
				}
				//任务被抢提示
				function fullTips(){
					layer.open({
						admin : 'up',
						time : 3,
						title : ['暂无法抢此类型任务','background-color:#FFFAE8;color:red;'],
						content : '您需要去个人中心完善您的资料'
					});
				}
				//抢单失败
				function errorTips(){
					layer.open({
						admin : 'up',
						time : 2,
						style: 'border: 1px solid skyblue; background-color:#FFFAE8; color:red;',
						content : '网络有点小问题，稍后再试'
					});
				}	
				//隐藏当前任务
				function hideTask(e){
					$('.'+e).hide(2000);
					console.log(e);
				}
		
		//$(document).click(function(e){
			//判断按下的是抢单按钮还是删除按钮,截取首位为b是抢,为d是删除
			//var btnId = e.target.id;
			//if(btnId.substr(0,3) == 'btn'){
			function grap_task(idNum){
				var num = idNum;//获得当前的pd.id
				var headId = "abc"+num;//合成整个任务div的class
				//var n = btnId.search(/btn/);//返回值是0和-1;-1表示没有匹配到,0表示匹配成功
				var openid = "<?php echo $openid; ?>";
				if(n == 0){
					//将按钮id送出去,前台显示是否抢单成功
					$.ajax({
						type :'get',
						url : 'http://xiaoyuanfeixia.com/privite/app/page/doingTask.php?id='+num+'&openid='+openid,
						dateType : 'json',
						//加载等待
						beforeSend : function loading(){
										layer.open({
											className:'tips',
											type : 2,
											content : '激烈抢单中'
										});
									},
						success : function(dateRtn){
							layer.closeAll();//清空弹出层
							var date = JSON.parse(dateRtn);
							
							if(date == 1){
								successTips();
								hideTask(headId);
							}else if(date == 2){
								repTips();
								hideTask(headId);
							}else if(date == 3){
								fullTips();
							}else if(date == 4){
								errorTips();
							}
						},
						error : function(e){
							errorTips();
						}
				})
			}
			}
		  //删除订单函数
			function dele_task(btnid){
				var num = btnId.substr(6);//获得当前的pd.id
				var headId = "shi"+num;//合成整个任务div的id
				var flag = $('#flag').html();
				//如果已结单,正常删除
				if(flag == "已结单"){
					$.alert("删除后将不可恢复，确认删除此条任务记录吗？", "确认删除", function() {
						//点击确认后的回调函数
						$.ajax({
							type : 'post',
							url: 'http://xiaoyuanfeixia.com/privite/app/page/delDoneTask.php',
							dataType: 'json',
							data:{
								id:num
							},
							success:function(e){
								var data = JSON.parse(e);
								if(data == 1){
									$.toast("删除成功");
									hideTask(headId);
								}else if(data == 0){
									$.toast("删除失败", "forbidden");
								}
							},
							error:function(){
								errorTips();
							}
						})
					});
				}else{
					//如果是已抢单,还没有结单
					$.confirm("任务还没有完成，确认删除吗？    测试阶段，本次删除不会扣除信用积分！", "取消订单", function() {
					//点击 确认后的回调函数
						$.ajax({
							type : 'post',
							url: 'http://xiaoyuanfeixia.com/privite/app/page/delDoneTask.php',
							dataType: 'json',
							data:{
								id:num
							},
							success:function(e){
								var data = JSON.parse(e);
								if(data == 1){
									$.toast("删除成功");
									hideTask(headId);
								}else if(data == 0){
									$.toast("删除失败", "forbidden");
								}
							},
							error :function(jqXHR,textStatus,errorThrown){
								console.log(jqXHR);
								console.log(textStatus);
								console.log(errorThrown);
							}
						})
					},function(){//取消操作
							console.log("取消删除");
						});
				}				
		}
		});			
	//	});
	</script>
	<script src="http://xiaoyuanfeixia.com/html_lib/js/layer/mobile/layer.js" type="text/javascript" charset="utf-8"></script>

</html>
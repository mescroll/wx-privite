
			// 选择任务类型
      $("#name").picker({
        title: "选择任务类型",
        cols: [
          {
            textAlign: 'center',
            values: ['取快递', '借物品', '带饭', '跑腿办事', '兼职', '技能求助', '其他']
          }
        ],
        onChange: function(p, v, dv) {
          console.log(p, v, dv);
        },
        onClose: function(p, v, d) {
          console.log("close");
        }
      });
			// 任务截止时间
      $('#datetime-picker').datetimePicker({
				title : '请选择任务截止时间',
				yearSplit: '年',
        monthSplit: '月',
        dateSplit: '日',
				min : '2018-10-20',
				max : '2021-12-31'
			});
			// 检查发布范围的开关
				$(function () {
          $("#ground").bind("click", function () {
            if($("#btn").val()=="off"){
               $("#btn").val("on");                       
                }else{
                      $("#btn").val("off");
                     }
                });
            });

	
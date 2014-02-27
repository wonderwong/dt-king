jQuery.validationEngine.allRules = {
               "required":{ 
						"regex":"none",
						"alertText":"* 非空选项. ",
  						"alertTextTitle":"* Please specify ",
						"alertTextCheckboxMultiple":"* 请选择一个单选框.",
						"alertTextCheckboxe":"* 请选择一个复选框."},
					"or": {
					   "regex":"none",
					   "alertText":"Please fill in one of these fields: ",
					   "alertText2":"* ",
					   "alertText3":"or:",
					   "alertTextTitle":"* Specify "
					},
					"length":{
						"regex":"none",
						"alertText":"* 长度必须在 ",   
                        "alertText2":" 至 ",   
                        "alertText3": " 之间."},  
					"maxCheckbox":{
						"regex":"none",
						"alertText":"* 最多选择 ",//官方文档这里有问题   
                        "alertText2":" 项."},  
					"minCheckbox":{
						"regex":"none",
						"alertText":"* 至少选择 ",
						"alertText2":" 项. "},	
					"confirm":{
						"regex":"none",
						"alertText":"* 两次输入不一致,请重新输入."},		
					"telephone":{
						"regex":"/^[0-9\-\(\)\ ]+$/",
						"alertText":"* 请输入有效的电话号码,如:010-29292929."},	
					"email":{
						"regex":"/^[a-zA-Z0-9_\.\-]+\@([a-zA-Z0-9\-]+\.)+[a-zA-Z0-9]{2,4}$/",
						"alertText":"* 请输入有效的邮件地址."},	
					"date":{
                         "regex":"/^[0-9]{4}\-\[0-9]{1,2}\-\[0-9]{1,2}$/",
                         "alertText":"* 请输入有效的日期,如:2008-08-08."},
					"onlyNumber":{
						"regex":"/^[0-9\ ]+$/",
						"alertText":"* 请输入数字."},	
					"noSpecialCaracters":{
						"regex":"/^[0-9a-zA-Z]+$/",
						"alertText":"* 请输入英文字母和数字."},	
					"ajaxUser":{
						"file":"validateUser.php",//ajax验证用户名，会post如下参数：validateError ajaxUser；validateId user；validateValue cccc
						"alertTextOk":"* This user is available",	
						"alertTextLoad":"* Loading, please wait",
						"alertText":"* This user is already taken"},	
					"ajaxName":{
						"file":"validateUser.php",
						"alertText":"* This name is already taken",
						"alertTextOk":"* This name is available",	
						"alertTextLoad":"* Loading, please wait"},		
					"onlyLetter":{
						"regex":"/^[a-zA-Z\ \']+$/",
						"alertText":"* 请输入英文字母."}
					}	

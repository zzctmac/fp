/**
* Created by <?=$owner?> on <?=$date?>.
*/


var <?=$name?> = {
formName:null,
api:"<?=$api?>",
setFormName:function(formName){
this.formName = formName;
},
callback:function(res){

},
setValidate: function(){
var p = this;
$(this.formName).validate({
submitHandler: function(form){   //表单提交句柄,为一回调函数，带一个参数：form
alert("提交表单");
var data = getFormJson(form);
var type = "POST";
var dataType = "JSON";
var url = base_url + p.api;
$.ajax({
url: url,
data:data,
type:type,
dataType:dataType
}).done(this.callback);
return;
form.submit();   //提交表单
},
rules:{
realName:{
required:true
},
tel:{
required:true,
rangelength:[11, 11]
},
checkCode:{
required:true
},
pwd:{
required:true,
minlength:6,
maxlength:16
}
}
});
}
};
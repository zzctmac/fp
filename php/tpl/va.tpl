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
if(res.code == 1) {

} else {
alert(res.msg);
}
},
setValidate: function(){
var p = this;
$(this.formName).validate({
submitHandler: function(form){   //表单提交句柄,为一回调函数，带一个参数：form
var data = getFormJson(form);
var type = "POST";
var dataType = "JSON";
var url = base_url + p.api;
$.ajax({
url: url,
data:data,
type:type,
dataType:dataType
}).done(p.callback);
},
rules:<?=$rules?>,
messages:<?=$messages?>
});
}
};
@extends('admin.layouts.base')
@section('content')
<article class="cl pd-20">
    <form method="post" class="form form-horizontal" id="form-admin-role-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>角色名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="name" name="name" datatype="*4-16" nullmsg="用户账户不能为空">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">备注：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" value="" placeholder="" id="description" name="description">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">角色权限</label>
            <div class="formControls col-xs-8 col-sm-9">
                @foreach($data as $value)
                <dl class="permission-list">
                    <dt>
                        <label>
                            <input type="checkbox" value="{{$value['id']}}" name="permissions" id="user-Character-0">
                            {{$value['label']}}
                        </label>
                    </dt>

                    <dd>
                        <dl class="cl permission-list2">

                            <dd>
                                @if(isset($value['son']))
                                    @foreach($value['son'] as $son)
                                    <label class="">
                                        <input type="checkbox" value="{{$son['id']}}" name="permissions" id="user-Character-0-0-0">
                                       {{$son['label']}}
                                    </label>
                                    @endforeach
                                @endif
                            </dd>

                        </dl>
                    </dd>
                </dl>
                @endforeach

            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <button type="submit" class="btn btn-success radius" id="admin-role-save" name="admin-role-save"><i class="icon-ok"></i> 确定</button>
            </div>
        </div>
    </form>
</article>

@endsection
@section('my-js')
    <script>
        $(function(){
            $(".permission-list dt input:checkbox").click(function(){
                $(this).closest("dl").find("dd input:checkbox").prop("checked",$(this).prop("checked"));
            });
            $(".permission-list2 dd input:checkbox").click(function(){

                var l =$(this).parent().parent().find("input:checked").length;

                var l2=$(this).parents(".permission-list").find(".permission-list2 dd").find("input:checked").length;
                if($(this).prop("checked")){
                    $(this).closest("dl").find("dt input:checkbox").prop("checked",true);
                    $(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",true);
                }
                else{
                    if(l==0){
                        $(this).closest("dl").find("dt input:checkbox").prop("checked",false);
                    }
                    if(l2==0){
                        $(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked",false);
                    }
                }
            });

            $("#form-admin-role-add").validate({
                rules:{
                    name:{
                        required:true,
                    },
                },
                onkeyup:false,
                debug:true,
                focusCleanup:true,
                success:"valid",
                submitHandler:function(form){
                    var obj = $("input[name ='permissions']:checked");
                    var arr = [];
                    obj.each(function(){
                        arr.push($(this).val());
                    });

                    $(form).ajaxSubmit({
                        type:'post',
                        url:'{{route('admin.role.store')}}',
                        dataType:'json',
                        data:{
                            name :$('#name').val(),
                            description:$('#description').val(),
                            permissions:arr ,
                            _token:'{{csrf_token()}}'
                        },
                        beforeSend:function(){

                        },
                        success:function(data){

                            if(data == null){
                                layer.msg('服务器错误请稍候再试',{icon:2,time:2000});
                                return ;
                            }

                            if(data.status !=1){
                                layer.msg(data.msg,{icon:2,time:2000});
                                return ;
                            }
                            layer.msg(data.msg,{icon:1,time:1000});
                            window.location.href ="{{route('admin.role.index')}}";

                        },

                        error:function(data){

                            console.log(data.status);
                            if(data.status === 422){
                                var errors = $.parseJSON(data.responseText);

                                var msg = "";
                                $.each(errors,function(index,value){

                                    msg += value[0]+" "
                                });
                                layer.msg(msg,{icon:2,time:2000});
                                return;
                            }
                            layer.msg('服务器错误',{icon:2,time:2000});


                        }
                    });

                }



            });
        });
    </script>
@endsection

@include('admin.permission._meta')
<body>
<div class="page-container">
        <form  method="post" class="form form-horizontal" id="form-permission-create">
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span> 权限规则:</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$permission->name}}" placeholder="权限规则" id="name" name="name">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red">*</span>权限名称:</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$permission->label}}" placeholder="权限名称" id="label" name="label">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2"><span class="c-red"></span>顶级权限图标:</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$permission->icon}}" placeholder="权限名称" id="icons" name="icons">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">父级权限：</label>
                <div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
				<select class="select" name="cid" size="1">
                    <option value="0">顶级权限</option>
                    @foreach($data as $value){

                        <option value="{{$value->id}}"
                                @if($value->id==$permission->cid )
                                selected="selected"
                                @endif
                        >
                            {{$value->label}}
                        </option>

                    }
                    @endforeach
                </select>
				</span> </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-2">权限概述:</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea name="textarea" cols="" rows="" class="textarea"  placeholder="权限描述...100个字符以内" dragonfly="true" ></textarea>
                    <p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </div>


    @include('admin.layouts._foot')
        <script>
            $(function(){
                $("#form-permission-create").validate({
                    rules:{
                        name:{
                            required:true
                        },
                        label:{
                            required:true
                        }

                    },
                    onkeyup:false,
                    focusCleanup:true,
                    success:"valid",
                    submitHandler:function(form){
                        $(form).ajaxSubmit({
                            type:'post',
                            url:'{{route('admin.permission.store')}}',
                            dataType:'json',
                            data:{
                                name :$('#name').val(),
                                label:$('input[label]').val(),
                                icons:$('input[icons]').val(),
                                description:$('textarea[textarea]').val(),
                                cid:$('select').val(),
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
                                window.location.href ="{{route('admin.permission.index')}}";

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
</body>
</html>
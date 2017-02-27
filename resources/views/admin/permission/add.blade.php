@extends('admin.layouts.base')
@section('content')
    <title>添加权限 - 权限管理</title>
    <meta name="keywords" content="H-ui.admin v3.0,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
    <meta name="description" content="H-ui.admin v3.0，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
    </head>
    <body>
    <article class="cl pd-20">
        <form  method="post" class="form form-horizontal" id="form-permission-create">
            {{csrf_field()}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span> 权限规则:</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="权限规则" id="name" name="name">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>权限名称:</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="权限名称" id="label" name="label">
                </div>
            </div>
            @if($data['cid'] == 0)
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>顶级权限图标:</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="" placeholder="权限名称" id="icons" name="icons">
                </div>
            </div>
            @endif

            {{--<div class="row cl">--}}
                {{--<label class="form-label col-xs-4 col-sm-3">父级权限：</label>--}}
                {{--<div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">--}}
				{{--<select class="select" name="cid" size="1">--}}
                    {{--<option value="0">顶级权限</option>--}}
                    {{--@foreach($data as $value){--}}
                         {{--<option value="{{$value->id}}"> {{$value->label}}</option>--}}
                    {{--}--}}
                    {{--@endforeach--}}
                {{--</select>--}}
				{{--</span> --}}
                {{--</div>--}}
            {{--</div>--}}
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">权限概述:</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <textarea name="textarea" id="textarea" cols="" rows="" class="textarea"  placeholder="权限描述...100个字符以内" dragonfly="true" ></textarea>
                    <p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
                </div>
            </div>
            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </article>

@endsection

@section('my-js')
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
                            description:$('#textarea').val(),
                            cid:'{{$data['cid']}}',
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
@endsection
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Ajax &mdash; CKEditor Sample</title>
    <meta content="text/html; charset=utf-8" http-equiv="content-type" />
    <script type="text/javascript" src="{{URL::asset('assets/ckeditor/ckeditor.js')}}"></script>
    <script src="{{URL::asset('assets/ckeditor/_samples/sample.js')}}" type="text/javascript"></script>
    <link href="{{URL::asset('assets/ckeditor/_samples/sample.css')}}" rel="stylesheet" type="text/css" />
    
</head>
<body>
   
    <form action="sample_posteddata.php" method="post">
        <p>
            <label for="editor1"></label>
            <textarea cols="80" id="editor1" name="editor1" rows="10"></textarea>
            <script type="text/javascript">
            //<![CDATA[

                CKEDITOR.replace( 'editor1', {
                    extraPlugins : 'autogrow',
                    removePlugins : 'resize'
                });

            //]]>
            </script>
        </p>
    </form>
</body>
</html>

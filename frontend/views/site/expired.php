<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = "Verified";
?>


<link href="/css/site.css" rel="stylesheet">
<style>
    /* latin-ext */
    @font-face {
        font-family: 'Audiowide';
        font-style: normal;
        font-weight: 400;
        src: local('Audiowide Regular'), local('Audiowide-Regular'), url('/font/audiowide_latin_ext.woff2') format('woff2');

    }
    /* latin */
    @font-face {
        font-family: 'Audiowide';
        font-style: normal;
        font-weight: 400;
        src: local('Audiowide Regular'), local('Audiowide-Regular'), url('/font/audiowide_latin.woff2') format('woff2');

    }

    .newtext {
        font-size: 72px;
        background: -webkit-linear-gradient( #1b4f72  , #3c8dbc);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font: normal 52px/1 "Audiowide", Helvetica, sans-serif;
        -o-text-overflow: ellipsis;
        text-overflow: ellipsis;
        font-family: 'Audiowide';
        font-size: 60px;
        text-align: center;
    }
    .img-responsive {
        display: block;
        max-width: 100%;
        height: auto;
        margin:auto;

    }

</style>


<div class="body-content" style="margin:10%;background:#b1d1e4;"  >
    <br>

    <div class="d-flex align-items-left" >
        <div class="row" style="text-align:center">
            <div class="col-md-12 ">
                <p style="font-family: 'Audiowide';font-size:30px;color:#1b4f72;text-align:center;vertical-align: central;color:Maroon">The URL Verification is no longer valid!</p>
            </div>

        </div>
        <div class="row"> 
            <p style="font-family: 'Audiowide';font-size:15px;color:#1b4f72;text-align:center;vertical-align: central;color:maroon">
                Please check your URL.
            </p>
        </div>
        <div class="row">

            <div class="col-md-6 text-md-right" >
                <br>
                <img src="/images/onelablogonew.png" style="width: 80%;border-radius: 15px 15px;display: block; height: auto; max-width: 100%;margin:0 auto;">
            </div>
            <div class="col-md-6 text-md-right">
                <h1 class="newtext">
                    E.U.L.I.M.S
                </h1>
                  <p style="font-family: 'Audiowide';font-size:18px;color:#1b4f72;text-align:center;vertical-align: central">
                Enhanced Unified Laboratory Information Management System
            </p>
            </div>
        </div>
       



    </div>
</div>

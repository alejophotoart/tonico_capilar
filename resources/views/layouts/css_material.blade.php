<style>

.input-material {
 bottom: 0 !important;
 color: #666 !important;
 width: 95% !important;
 border: none !important;
 outline: none !important;
 padding: 10px !important;
 font-size: 1.3em !important;
 /* position: absolute !important; */
 background: transparent !important;
 transition: all 0.1s ease-in-out !important;
 border-bottom: 1px solid #E0E0E0 !important;
}

input:-webkit-autofill {
  -webkit-box-shadow: 0 0 0px 1000px #fff inset !important;

}

.label-material, .label-material-textarea {
 /* bottom: 25px !important; */
 font-size: 1.2em !important;
 /* position: absolute !important; */
 pointer-events: none !important;
 transition: 0.1s ease-in-out !important;
 font-weight: 500;
}

.bar {
 bottom: 1.5px !important;
 width: 95% !important;
 position: absolute !important;
}

.input-material.filled {
}
.input-material:focus ~ label, .input-material.filled ~ label {
 bottom: 45px !important;
 font-size: 16px !important;
}
.input-material:focus ~ .label-material-textarea, .input-material.filled ~ .label-material-textarea {
 bottom: 10px !important;
 color: #444 !important;
 font-size: 16px !important;
}

.bar:before, .bar:after {
 content: "" !important;
 width: 0 !important;
 height: 2px !important;
 position: absolute !important;
 background: #444 !important;
 transition: all 0.2s ease-in-out !important;

}
.bar:before {
 left: 50% !important;
}
.bar:after {
 right: 50% !important;
}

.input-material:focus ~ .bar:before, .input-material:focus ~ .bar:after {
 width: 50% !important;
}
/* .input-material:valid {
 border-bottom: 1px solid #00E676 !important;
} */
/* .input-material:valid ~ .bar:before, .input-material:valid ~ .bar:after {
 background: #00E676 !important; */

/* .input-material:valid ~ label {
 color: #00E676 !important;
} */

.content-login{
       width: 100%;
       /* height: 100%; */
       background-position: center;
       background-repeat: no-repeat;
       background-attachment: fixed;
       background-size: cover;
       display: flex;
       justify-content: center;
       align-items: center;
   }
   .box-login{
       width: 78%;
       height: 75%;
       background: #ffffffe3;
       display: flex;
       flex-flow: row;
       box-shadow: 0 5px 20px rgba(0, 0, 0, 0.06), 0 6px 6px rgba(0, 0, 0, 0.09);
   }
   .img-login{
       width: 50%;
       /* height: 100%; */
       display: flex;
       justify-content: center;
       align-items: center;
   }
   .form-login{
       width: 50%;
       height: 100%;
       padding: 12% 2% 5% 5%;

   }
   .img-logo-login{
       width: 60%;
       height: auto;
       margin-left: 20%;

   }
   .loginForm{
     width: 100%;
     height: 80%;
   }

   .has-feedback {
   width: 100%;
   height: 24%;
}
.btn-material{
 border-radius: 18px  !important;
 width: 75% !important;
 height: 40px;
 margin-top: 10% !important;
 margin-left: 11%;
 font-size: 1.2em !important;
}
.btn {
   border-radius: 18px !important;
   }
.btn-material:hover{

}



/* Select */
.material-select {
   position: relative;
   cursor: pointer;
   background-color: transparent;
   border: none;
   border-bottom: 1px solid #ccc;
   color: #888 !important;
   outline: none;
   height: 3rem;
   line-height: 3rem;
   width: 100%;
   font-size: 16px;
   margin: 0 0 8px 0;
   padding: 0;
   display: block;
   bottom: 15px;
}



/*TEXTAREA*/


.form-element-field {
 outline: none;
 height: 1.5rem;
 display: block;
 background: none;
 padding: 0.125rem 0.125rem 0.0625rem;
 font-size: 1rem;
 border: 0 solid transparent;
 line-height: 1.5;
 width: 100%;
 color: #333;
 box-shadow: none;
 opacity: 0.001;
 transition: opacity 0.28s ease;
 will-change: opacity;
}

.form-element-field:-ms-input-placeholder {
 color: #a6a6a6;
 transform: scale(0.9);
 transform-origin: left top;
}

.form-element-field::placeholder {
 color: #a6a6a6;
 transform: scale(0.9);
 transform-origin: left top;
}

.form-element-field:focus ~ .form-element-bar::after {
 transform: rotateY(0deg);
}

.form-element-field:focus ~ .form-element-label {
 color: #337ab7;
}

.form-element-field.-hasvalue,
.form-element-field:focus {
 opacity: 1;
}

.form-element-field.-hasvalue ~
.form-element-field:focus ~ {
 transform: translateY(-100%) translateY(-0.5em) translateY(-2px) scale(0.9);
 cursor: pointer;
 pointer-events: auto;
}


input.form-element-field:not(:placeholder-shown),
textarea.form-element-field:not(:placeholder-shown) {
 opacity: 1;
}

input.form-element-field:not(:placeholder-shown) ~
textarea.form-element-field:not(:placeholder-shown) ~  {
 transform: translateY(-100%) translateY(-0.5em) translateY(-2px) scale(0.9);
 cursor: pointer;
 pointer-events: auto;
}

textarea.form-element-field {
 height: auto;
 min-height: 3rem;
}

select.form-element-field {
 -webkit-appearance: none;
 -moz-appearance: none;
 appearance: none;
 cursor: pointer;
}


.form-element-field[type="number"] {
 -moz-appearance: textfield;
}

.form-element-field[type="number"]::-webkit-outer-spin-button,
.form-element-field[type="number"]::-webkit-inner-spin-button {
 -webkit-appearance: none;
 margin: 0;
}

.form-element-bar {
 position: relative;
 height: 1px;
 display: block;
}

.form-element-bar::after {
 content: "";
 position: absolute;
 bottom: 0;
 left: 0;
 right: 0;
 background: #337ab7;
 height: 2px;
 display: block;
 transform: rotateY(90deg);
 transition: transform 0.28s ease;
 will-change: transform;
}


.form-element-label {
 position: absolute;
 top: 0.75rem;
 line-height: 1.5rem;
 pointer-events: none;
 padding-left: 0.125rem;
 z-index: 1;
 font-size: 1.2em;
 font-weight: 500;
 white-space: nowrap;
 overflow: hidden;
 margin: 0;
 color: #888;
 transform: translateY(-50%);
 transform-origin: left center;
}

@media (max-width: 900px){
 .img-logo-login {
   width: 40%;
   height: auto;
   margin-left: 30%;
   margin-top: 15%;
}
.img-login {
   width: 100%;
   height: 30%;
   display: flex;
   justify-content: center;
   align-items: center;
}
.form-login {
   width: 100%;
   height: 80%;
   padding: 2% 2% 5% 5%;
}

.box-login {
   width: 85%;

   display: block;

}
}




</style>

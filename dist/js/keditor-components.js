/**
 * @license
 KEditor v2.0.1 | Copyright (c) 2016-present Kademi (http://kademi.co) */
 'use strict';
 !function(root, factory) {
   if ("object" == typeof exports && "object" == typeof module) {
     module.exports = factory(require("KEditor"), require("jQuery"), require("CKEDITOR"));
   } else {
     if ("function" == typeof define && define.amd) {
       define(["KEditor", "jQuery", "CKEDITOR"], factory);
     } else {
       var jobInfoUpdate = "object" == typeof exports ? factory(require("KEditor"), require("jQuery"), require("CKEDITOR")) : factory(root.KEditor, root.jQuery, root.CKEDITOR);
       var i;
       for (i in jobInfoUpdate) {
         ("object" == typeof exports ? exports : root)[i] = jobInfoUpdate[i];
       }
     }
   }
 }("undefined" != typeof self ? self : this, function(__WEBPACK_EXTERNAL_MODULE_61__, array, e) {
   return function(e) {
     /**
      * @param {string} i
      * @return {?}
      */
     function t(i) {
       if (n[i]) {
         return n[i].exports;
       }
       var module = n[i] = {
         i : i,
         l : false,
         exports : {}
       };
       return e[i].call(module.exports, module, module.exports, t), module.l = true, module.exports;
     }
     var n = {};
     return t.m = e, t.c = n, t.d = function(d, name, n) {
       if (!t.o(d, name)) {
         Object.defineProperty(d, name, {
           enumerable : true,
           get : n
         });
       }
     }, t.r = function(x) {
       if ("undefined" != typeof Symbol && Symbol.toStringTag) {
         Object.defineProperty(x, Symbol.toStringTag, {
           value : "Module"
         });
       }
       Object.defineProperty(x, "__esModule", {
         value : true
       });
     }, t.t = function(o, proplist) {
       if (1 & proplist && (o = t(o)), 8 & proplist) {
         return o;
       }
       if (4 & proplist && "object" == typeof o && o && o.__esModule) {
         return o;
       }
       /** @type {!Object} */
       var d = Object.create(null);
       if (t.r(d), Object.defineProperty(d, "default", {
         enumerable : true,
         value : o
       }), 2 & proplist && "string" != typeof o) {
         var s;
         for (s in o) {
           t.d(d, s, function(namefrom) {
             return o[namefrom];
           }.bind(null, s));
         }
       }
       return d;
     }, t.n = function(e) {
       /** @type {function(): ?} */
       var n = e && e.__esModule ? function() {
         return e.default;
       } : function() {
         return e;
       };
       return t.d(n, "a", n), n;
     }, t.o = function(o, x) {
       return Object.prototype.hasOwnProperty.call(o, x);
     }, t.p = "", t(t.s = 7);
   }([function(module, canCreateDiscussions) {
     /** @type {!Function} */
     module.exports = __WEBPACK_EXTERNAL_MODULE_61__;
   }, function(module, canCreateDiscussions) {
     /** @type {!Function} */
     module.exports = array;
   }, function(context, canCreateDiscussions) {
     /** @type {!Function} */
     context.exports = e;
   }, , function(canCreateDiscussions, isSlidingUp, dontForceConstraints) {
   }, function(canCreateDiscussions, isSlidingUp, dontForceConstraints) {
   }, , function(canCreateDiscussions, d, e) {
     e.r(d);
     var s = e(0);
     var line = e.n(s);
     line.a.components.audio = {
       settingEnabled : true,
       settingTitle : "Audio Settings",
       init : function(tablixBody, dom, e, customNode) {
         var $roller = e.find(".keditor-component-content");
         if (0 === $roller.find(".audio-wrapper").length) {
           $roller.wrapInner('<div class="audio-wrapper"></div>');
         }
       },
       initSettingForm : function(form, keditor) {
         form.append('<form class="form-horizontal">     <div class="form-group">         <label class="col-sm-12">Audio file</label>         <div class="col-sm-12">             <div class="audio-toolbar">                 <a href="#" class="btn-audio-upload btn btn-sm btn-primary"><i class="fa fa-upload"></i></a>                 <input class="audio-upload" type="file" style="display: none" />             </div>         </div>     </div>     <div class="form-group">         <label class="col-sm-12">Autoplay</label>         <div class="col-sm-12">             <input type="checkbox" class="audio-autoplay" />         </div>     </div>     <div class="form-group">         <label class="col-sm-12">Show Controls</label>         <div class="col-sm-12">             <input type="checkbox" class="audio-controls" checked />         </div>     </div>     <div class="form-group">         <label class="col-sm-12">Width (%)</label>         <div class="col-sm-12">             <input type="number" min="20" max="100" class="form-control audio-width" value="100" />         </div>     </div></form>');
         var event = form.find(".audio-upload");
         form.find(".btn-audio-upload").off("click").on("click", function(dom_event) {
           dom_event.preventDefault();
           event.trigger("click");
         });
         event.off("change").on("change", function() {
           var file = this.files[0];
           if (/audio/.test(file.type)) {
             keditor.getSettingComponent().find("audio").attr("src", URL.createObjectURL(file));
           } else {
             alert("Your selected file is not an audio file!");
           }
         });
         form.find(".audio-autoplay").on("click", function() {
           keditor.getSettingComponent().find("audio").prop("autoplay", this.checked);
         });
         form.find(".audio-controls").on("click", function() {
           keditor.getSettingComponent().find("audio").prop("controls", this.checked);
         });
         form.find(".audio-width").on("change", function() {
           var audio = keditor.getSettingComponent().find("audio");
           audio.parent().attr("data-width", this.value);
           audio.css("width", this.value + "%");
         });
       },
       showSettingForm : function(component, array, form) {
         var elem = array.find("audio");
         var t = elem.parent();
         var $realtime = component.find(".audio-autoplay");
         var uncheckedInput = component.find(".audio-controls");
         var $conditionsRuleMajor = component.find(".audio-width");
         $realtime.prop("checked", !!elem.attr("autoplay"));
         uncheckedInput.prop("checked", !!elem.attr("controls"));
         $conditionsRuleMajor.val(t.attr("data-width") || 100);
       }
     };
     e(4);
     var element;
     var child;
     var c = e(1);
     var $ = e.n(c);
     line.a.components.form = {
       emptyContent : '<p class="text-muted lead text-center"><br />[No form content]<br /><br /></p>',
       renderForm : function(selector) {
         var $col = selector.find(".form-content");
         var testContainer = $()("<div />");
         testContainer.formRender({
           dataType : "json",
           formData : child.actions.getData("json")
         });
         $col.html(testContainer.html());
         if ($col.hasClass("form-horizontal")) {
           $col.children("div").each(function() {
             var t = $()(this);
             var uiType = $col.attr("data-grid") || "4-8";
             if (uiType = uiType.split("-"), t.attr("class")) {
               if (t.hasClass("fb-button")) {
                 t.find("button").wrap('<div class="col-sm-'.concat(uiType[1], " col-sm-offset-").concat(uiType[0], '"></div>'));
               } else {
                 var $sodLabel = t.children("label");
                 var wrapper = t.children("input, select, textarea");
                 var a = t.children("div");
                 $sodLabel.addClass("control-label col-sm-".concat(uiType[0]));
                 if (a.length > 0) {
                   a.addClass("col-sm-".concat(uiType[1]));
                 } else {
                   wrapper.addClass("form-control").wrap('<div class="col-sm-'.concat(uiType[1], '"></div>'));
                 }
               }
             }
           });
         }
       },
       initModal : function(self) {
         var obj = this;
         (element = self.initModal("keditor-modal-form")).find(".keditor-modal-title").html("Design form");
         element.css({
           visibility : "hidden",
           display : "block",
           opacity : 1
         });
         element.find(".keditor-modal-body").append('\n            <div class="form-builder-area-wrapper">\n                <div class="form-builder-area"></div>\n            </div>\n        ');
         child = element.find(".form-builder-area").formBuilder({
           showActionButtons : false,
           dataType : "json",
           disableFields : ["autocomplete", "paragraph", "header"],
           disabledAttrs : ["access"],
           typeUserDisabledAttrs : {
             "checkbox-group" : ["toggle", "inline"]
           }
         });
         element.find(".keditor-modal-footer").html('\n            <button type="button" class="keditor-ui keditor-btn keditor-btn-default keditor-modal-close">Close</button>\n            <button type="button" class="keditor-ui keditor-btn keditor-btn-primary btn-save-form">Save</button>\n        ');
         element.find(".btn-save-form").on("click", function(event) {
           event.preventDefault();
           var app = self.getSettingComponent();
           app.find(".form-data").html(child.actions.getData("json"));
           obj.renderForm(app);
           self.hideModal(element);
         });
         setTimeout(function() {
           element.css({
             visibility : "",
             display : "",
             opacity : ""
           });
         }, 500);
       },
       init : function(tablixBody, dom, selector, rules) {
         var top_vals_el = selector.find(".keditor-component-content");
         var expRecords = selector.find(".form-content");
         if (0 === selector.find(".form-data").length) {
           top_vals_el.append('<div class="form-data" style="display: none !important;"></div>');
         }
         if (0 === expRecords.length) {
           top_vals_el.append('<form class="form-content">'.concat(this.emptyContent, "</form>"));
         }
         if (!element) {
           this.initModal(rules);
         }
       },
       settingEnabled : true,
       settingTitle : "Form Settings",
       initSettingForm : function(fields, self) {
         var that = this;
         fields.html('\n            <div class="form-horizontal">\n                <div class="form-group">\n                    <div class="col-sm-12">\n                       <button class="btn btn-primary btn-block btn-design-form" type="button"><i class="fa fa-paint-brush"></i> Design form</button>\n                    </div>\n                </div>\n                <div class="form-group">\n                    <label class="col-sm-12">Action</label>\n                    <div class="col-sm-12">\n                        <input type="text" class="form-control txt-form-action" />\n                    </div>\n                </div>\n                <div class="form-group">\n                    <label class="col-sm-12">Method</label>\n                    <div class="col-sm-12">\n                        <select class="form-control select-method">\n                            <option value="get">Get</option>\n                            <option value="post">Post</option>\n                            <option value="put">Put</option>\n                            <option value="delete">Delete</option>\n                        </select>\n                    </div>\n                </div>\n                <div class="form-group">\n                    <label class="col-sm-12">Enctype</label>\n                    <div class="col-sm-12">\n                        <select class="form-control select-enctype">\n                            <option value="text/plain">text/plain</option>\n                            <option value="multipart/form-data">multipart/form-data</option>\n                            <option value="application/x-www-form-urlencoded">application/x-www-form-urlencoded</option>\n                        </select>\n                    </div>\n                </div>\n                <div class="form-group">\n                    <label class="col-sm-12">Layout</label>\n                    <div class="col-sm-12">\n                        <select class="form-control select-layout">\n                            <option value="">Normal</option>\n                            <option value="form-horizontal">Horizontal</option>\n                            <option value="form-inline">Inline</option>\n                        </select>\n                    </div>\n                </div>\n                <div class="form-group select-grid-wrapper">\n                    <label class="col-sm-12">Grid setting</label>\n                    <div class="col-sm-12">\n                        <select class="form-control select-grid">\n                            <option value="2-10">col-2 col-10</option>\n                            <option value="3-9">col-3 col-9</option>\n                            <option value="4-8">col-4 col-8</option>\n                            <option value="5-7">col-5 col-7</option>\n                            <option value="6-6">col-6 col-6</option>\n                        </select>\n                        <small class="help-block">This setting is for width of label and control with number of cols as unit</small>\n                    </div>\n                </div>\n            </div>\n        ');
         fields.find(".btn-design-form").on("click", function(event) {
           event.preventDefault();
           var filteredView = self.getSettingComponent();
           child.actions.setData(filteredView.find(".form-data").html());
           self.showModal(element);
         });
         fields.find(".txt-form-action").on("change", function() {
           self.getSettingComponent().find(".form-content").attr("action", this.value);
         });
         fields.find(".select-method").on("change", function() {
           self.getSettingComponent().find(".form-content").attr("action", this.value);
         });
         fields.find(".select-enctype").on("change", function() {
           self.getSettingComponent().find(".form-content").attr("enctype", this.value);
         });
         fields.find(".select-layout").on("change", function() {
           var result = self.getSettingComponent();
           var oTable = result.find(".form-content");
           oTable.removeClass("form-inline form-horizontal");
           if (this.value) {
             oTable.addClass(this.value);
           }
           that.renderForm(result);
           fields.find(".select-grid-wrapper").css("display", "form-horizontal" === this.value ? "block" : "none");
         });
         fields.find(".select-grid").on("change", function() {
           var result = self.getSettingComponent();
           result.find(".form-content").attr("data-grid", this.value);
           that.renderForm(result);
         });
       },
       showSettingForm : function(component, values, form) {
         var form = values.find(".form-content");
         /** @type {string} */
         var value = "";
         if (form.hasClass("form-inline")) {
           /** @type {string} */
           value = "form-inline";
         } else {
           if (form.hasClass("form-horizontal")) {
             /** @type {string} */
             value = "form-horizontal";
           }
         }
         component.find(".txt-form-action").val(form.attr("action") || "");
         component.find(".select-method").val(form.attr("method") || "get");
         component.find(".select-enctype").val(form.attr("enctype"));
         component.find(".select-layout").val(value);
         component.find(".select-grid-wrapper").css("display", "form-horizontal" === value ? "block" : "none");
         component.find(".select-grid").val(form.attr("data-grid") || "4-8");
       }
     };
     line.a.components.googlemap = {
       init : function(tablixBody, dom, e, n) {
         var sel = e.find("iframe");
         var _normalY = sel.parent();
         n.initIframeCover(sel, _normalY);
       },
       settingEnabled : true,
       settingTitle : "Google Map Settings",
       initSettingForm : function(form, keditor) {
         form.append('<form class="form-horizontal">   <div class="form-group">       <div class="col-sm-12">           <button type="button" class="btn btn-block btn-primary btn-googlemap-edit">Update Map</button>       </div>   </div>   <div class="form-group">       <label class="col-sm-12">Aspect Ratio</label>       <div class="col-sm-12">           <button type="button" class="btn btn-sm btn-default btn-googlemap-169">16:9</button>           <button type="button" class="btn btn-sm btn-default btn-googlemap-43">4:3</button>       </div>   </div></form>');
         form.find(".btn-googlemap-edit").on("click", function(event) {
           event.preventDefault();
           /** @type {(null|string)} */
           var msg = prompt("Please enter Google Map embed code in here:");
           var audio = $()(msg);
           var i = audio.attr("src");
           if (audio.length > 0 && i && i.length > 0) {
             keditor.getSettingComponent().find(".embed-responsive-item").attr("src", i);
           } else {
             alert("Your Google Map embed code is invalid!");
           }
         });
         form.find(".btn-googlemap-169").on("click", function(event) {
           event.preventDefault();
           keditor.getSettingComponent().find(".embed-responsive").removeClass("embed-responsive-4by3").addClass("embed-responsive-16by9");
         });
         form.find(".btn-googlemap-43").on("click", function(event) {
           event.preventDefault();
           keditor.getSettingComponent().find(".embed-responsive").removeClass("embed-responsive-16by9").addClass("embed-responsive-4by3");
         });
       }
     };
     line.a.components.photo = {
       init : function(tablixBody, dom, element, customNode) {
         element.children(".keditor-component-content").find("img").css("display", "inline-block");
       },
       settingEnabled : true,
       settingTitle : "Photo Settings",
       initSettingForm : function(form, extra) {
         var settings = this;
         extra.options;
         form.append('<form class="form-horizontal">   <div class="form-group">       <div class="col-sm-12">             <input type="file" class="btn btn-primary" name="file" id="file" style="display: block" />       </div>   </div>   <div class="form-group">       <label for="photo-align" class="col-sm-12">Align</label>       <div class="col-sm-12">           <select id="photo-align" class="form-control">               <option value="left">Left</option>               <option value="center">Center</option>               <option value="right">Right</option>           </select>       </div>   </div>   <div class="form-group">       <label for="photo-style" class="col-sm-12">Style</label>       <div class="col-sm-12">           <select id="photo-style" class="form-control">               <option value="">None</option>               <option value="img-rounded">Rounded</option>               <option value="img-circle">Circle</option>               <option value="img-thumbnail">Thumbnail</option>           </select>       </div>   </div>   <div class="form-group">       <label for="photo-responsive" class="col-sm-12">Responsive</label>       <div class="col-sm-12">           <input type="checkbox" id="photo-responsive" />       </div>   </div>   <div class="form-group">       <label for="photo-width" class="col-sm-12">Width</label>       <div class="col-sm-12">           <input type="number" id="photo-width" class="form-control" />       </div>   </div>   <div class="form-group">       <label for="photo-height" class="col-sm-12">Height</label>       <div class="col-sm-12">           <input type="number" id="photo-height" class="form-control" />       </div>   </div></form>');
        
         jQuery("#file").on("change", function(e){
            e.preventDefault();
            var files = this.files[0];
            var formData = new FormData();
            formData.append("file", files);
            jQuery.ajax({
                url:"/editor/upload",//set your server side save script url
                type:"POST",
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false, 
                contentType: false,
                success: function (data) {
                    var image = extra.getSettingComponent().find("img");
                    image.attr("src", data);
                    image.css({
                        width : "",
                        height : ""
                    });
                    image.load(function() {
                        settings.showSettingForm.call(settings, form, extra.getSettingComponent(), extra);
                    });
                },
                error: function (data) {
                    alert(data.responseText);
                }
            });
            
        });
        
         form.find("#photo-align").on("change", function() {
           extra.getSettingComponent().find(".photo-panel").css("text-align", this.value);
         });
         form.find("#photo-responsive").on("click", function() {
           extra.getSettingComponent().find("img")[this.checked ? "addClass" : "removeClass"]("img-responsive");
         });
         form.find("#photo-style").on("change", function() {
           var t = extra.getSettingComponent().find("img");
           var selected = this.value;
           t.removeClass("img-rounded img-circle img-thumbnail");
           if (selected) {
             t.addClass(selected);
           }
         });
         var inputWidth = form.find("#photo-width");
         var inputHeight = form.find("#photo-height");
         inputWidth.on("change", function() {
           var modalImage = extra.getSettingComponent().find("img");
           /** @type {number} */
           var value = +this.value;
           /** @type {number} */
           var newHeight = Math.round(value / settings.ratio);
           if (value <= 0) {
             value = settings.width;
             newHeight = settings.height;
             this.value = value;
           }
           modalImage.css({
             width : value,
             height : newHeight
           });
           inputHeight.val(newHeight);
         });
         inputHeight.on("change", function() {
           var t = extra.getSettingComponent().find("img");
           /** @type {number} */
           var val = +this.value;
           /** @type {number} */
           var newWidth = Math.round(val * settings.ratio);
           if (val <= 0) {
             newWidth = settings.width;
             val = settings.height;
             this.value = val;
           }
           t.css({
             height : val,
             width : newWidth
           });
           inputWidth.val(newWidth);
         });
       },
       showSettingForm : function(form, component, keditor) {
         var self = this;
         var inputAlign = form.find("#photo-align");
         var inputResponsive = form.find("#photo-responsive");
         var inputWidth = form.find("#photo-width");
         var inputHeight = form.find("#photo-height");
         var cbbStyle = form.find("#photo-style");
         var playerContainer = component.find(".photo-panel");
         var $img = playerContainer.find("img");
         var align = playerContainer.css("text-align");
         if (!("right" === align && "center" === align)) {
           /** @type {string} */
           align = "left";
         }
         if ($img.hasClass("img-rounded")) {
           cbbStyle.val("img-rounded");
         } else {
           if ($img.hasClass("img-circle")) {
             cbbStyle.val("img-circle");
           } else {
             if ($img.hasClass("img-thumbnail")) {
               cbbStyle.val("img-thumbnail");
             } else {
               cbbStyle.val("");
             }
           }
         }
         inputAlign.val(align);
         inputResponsive.prop("checked", $img.hasClass("img-responsive"));
         inputWidth.val($img.width());
         inputHeight.val($img.height());
         $()("<img />").attr("src", $img.attr("src")).load(function() {
           /** @type {number} */
           self.ratio = this.width / this.height;
           self.width = this.width;
           self.height = this.height;
         });
       }
     };
     e(5);
     var el = e(2);
     var self = e.n(el);
     /** @type {boolean} */
     self.a.disableAutoInline = true;
     /**
      * @return {undefined}
      */
     self.a.dom.element.prototype.scrollIntoView = function() {
     };
     /**
      * @return {undefined}
      */
     self.a.dom.selection.prototype.scrollIntoView = function() {
     };
     /**
      * @return {undefined}
      */
     self.a.dom.range.prototype.scrollIntoView = function() {
     };
     line.a.components.text = {
       options : {
         toolbarGroups : [{
           name : "document",
           groups : ["mode", "document", "doctools"]
         }, {
           name : "editing",
           groups : ["find", "selection", "spellchecker", "editing"]
         }, {
           name : "forms",
           groups : ["forms"]
         }, {
           name : "basicstyles",
           groups : ["basicstyles", "cleanup"]
         }, {
           name : "paragraph",
           groups : ["list", "indent", "blocks", "align", "bidi", "paragraph"]
         }, {
           name : "links",
           groups : ["links"]
         }, {
           name : "insert",
           groups : ["insert"]
         }, "/", {
           name : "clipboard",
           groups : ["clipboard", "undo"]
         }, {
           name : "styles",
           groups : ["styles"]
         }, {
           name : "colors",
           groups : ["colors"]
         }],
         title : false,
         allowedContent : true,
         bodyId : "editor",
         templates_replaceContent : false,
         enterMode : "P",
         forceEnterMode : true,
         format_tags : "p;h1;h2;h3;h4;h5;h6",
         removePlugins : "table,magicline,tableselection,tabletools",
         removeButtons : "Save,NewPage,Preview,Print,Templates,PasteText,PasteFromWord,Find,Replace,SelectAll,Scayt,Form,HiddenField,ImageButton,Button,Select,Textarea,TextField,Radio,Checkbox,Outdent,Indent,Blockquote,CreateDiv,Language,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Styles,BGColor,Maximize,About,ShowBlocks,BidiLtr,BidiRtl,Flash,Image,Subscript,Superscript,Anchor",
         minimumChangeMilliseconds : 100
       },
       init : function(f, duration, fn, that) {
         var options = that.options;
         var $element = fn.children(".keditor-component-content");
         $element.prop("contenteditable", true);
         $element.on("input", function(p1__3354_SHARP_) {
           if ("function" == typeof options.onComponentChanged) {
             options.onComponentChanged.call(that, p1__3354_SHARP_, fn);
           }
           if ("function" == typeof options.onContainerChanged) {
             options.onContainerChanged.call(that, p1__3354_SHARP_, duration, f);
           }
           if ("function" == typeof options.onContentChanged) {
             options.onContentChanged.call(that, p1__3354_SHARP_, f);
           }
         });
         var editor = self.a.inline($element[0], this.options);
         editor.on("instanceReady", function() {
           $("#cke_" + $element.attr("id")).appendTo(that.wrapper);
           if ("function" == typeof options.onComponentReady) {
             options.onComponentReady.call(f, fn, editor);
           }
         });
         editor.on("key", function(e) {
           if (e.data.domEvent.$.ctrlKey && 86 === e.data.domEvent.$.keyCode || 13 === e.data.domEvent.$.keyCode) {
             console.log("Dont scroll!!");
             that.iframeBody.scrollTop($(editor.element.$).offset().top);
             setTimeout(function() {
             }, 10);
           }
         }, editor);
       },
       getContent : function(wrapAt, compensateForWrapping) {
         var $clueText = wrapAt.find(".keditor-component-content");
         var i = $clueText.attr("id");
         var aDS = self.a.instances[i];
         return aDS ? aDS.getData() : $clueText.html();
       },
       destroy : function(position, matrix) {
         var i = position.find(".keditor-component-content").attr("id");
         if (self.a.instances[i]) {
           self.a.instances[i].destroy();
         }
       }
     };
     line.a.components.video = {
       init : function(tablixBody, dom, element, customNode) {
         var video = element.children(".keditor-component-content").find("video");
         if (!video.parent().is(".video-wrapper")) {
           video.wrap('<div class="video-wrapper"></div>');
         }
       },
       getContent : function(wrapAt, compensateForWrapping) {
         var componentContent = wrapAt.children(".keditor-component-content");
         return componentContent.find("video").unwrap(), componentContent.html();
       },
       settingEnabled : true,
       settingTitle : "Video Settings",
       initSettingForm : function(form, keditor) {
         form.append('\n            <form class="form-horizontal">\n                <div class="form-group">\n                    <label for="video-input" class="col-sm-12">Video file</label>\n                    <div class="col-sm-12">\n                        <div class="video-toolbar">\n                            <a href="#" class="btn-video-input btn btn-sm btn-primary"><i class="fa fa-upload"></i></a>\n                            <input class="video-input" type="file" style="display: none" />\n                        </div>\n                    </div>\n                </div>\n                <div class="form-group">\n                    <label for="video-autoplay" class="col-sm-12">Autoplay</label>\n                    <div class="col-sm-12">\n                        <input type="checkbox" class="video-autoplay" />\n                    </div>\n                </div>\n                <div class="form-group">\n                    <label for="video-loop" class="col-sm-12">Loop</label>\n                    <div class="col-sm-12">\n                        <input type="checkbox" class="video-loop" />\n                    </div>\n                </div>\n                <div class="form-group">\n                    <label for="video-controls" class="col-sm-12">Show Controls</label>\n                    <div class="col-sm-12">\n                        <input type="checkbox" class="video-controls" checked />\n                    </div>\n                </div>\n                <div class="form-group">\n                    <label for="" class="col-sm-12">Ratio</label>\n                    <div class="col-sm-12">\n                        <input type="radio" name="video-radio" class="video-ratio" value="4/3" checked /> 4:3\n                    </div>\n                    <div class="col-sm-12">\n                        <input type="radio" name="video-radio" class="video-ratio" value="16/9" /> 16:9\n                    </div>\n                </div>\n                <div class="form-group">\n                    <label for="video-width" class="col-sm-12">Width (px)</label>\n                    <div class="col-sm-12">\n                        <input type="number" class="video-width form-control" min="320" max="1920" value="320" />\n                    </div>\n                </div>\n            </form>\n        ');
         var e = form.find(".video-input");
         form.find(".btn-video-input").on("click", function(event) {
           event.preventDefault();
           e.trigger("click");
         });
         e.on("change", function() {
           var file = this.files[0];
           var elem = keditor.getSettingComponent().find("video");
           if (/video/.test(file.type)) {
             elem.attr("src", URL.createObjectURL(file));
           } else {
             alert("Your selected file is not an video file!");
           }
         });
         form.find(".video-autoplay").on("click", function() {
           keditor.getSettingComponent().find("video").prop("autoplay", this.checked);
         });
         form.find(".video-loop").on("click", function() {
           keditor.getSettingComponent().find("video").prop("loop", this.checked);
         });
         form.find(".video-ratio").on("click", function() {
           keditor.getSettingComponent().find("video").attr("data-ratio", this.value);
           form.find(".video-width").trigger("change");
         });
         form.find(".video-controls").on("click", function() {
           keditor.getSettingComponent().find("video").prop("controls", this.checked);
         });
         form.find(".video-width").on("change", function() {
           var elem = keditor.getSettingComponent().find("video");
           /** @type {number} */
           var total = "16/9" === elem.attr("data-ratio") ? 16 / 9 : 4 / 3;
           /** @type {number} */
           var value = this.value / total;
           elem.attr("width", this.value);
           elem.attr("height", value);
         });
       },
       showSettingForm : function(component, options, form) {
         var $video = options.find("video");
         component.find(".video-autoplay").prop("checked", $video.prop("autoplay"));
         component.find(".video-loop").prop("checked", $video.prop("loop"));
         component.find(".video-ratio").prop("checked", false).filter('[value="' + $video.attr("data-ratio") + '"]').prop("checked", true);
         component.find(".video-controls").prop("checked", $video.prop("controls"));
         component.find(".video-width").val($video.attr("width"));
       }
     };
     line.a.components.vimeo = {
       init : function(tablixBody, dom, e, n) {
         var sel = e.find("iframe");
         var _normalY = sel.parent();
         n.initIframeCover(sel, _normalY);
       },
       settingEnabled : true,
       settingTitle : "Vimeo Settings",
       initSettingForm : function(form, keditor) {
         form.append('<form class="form-horizontal">   <div class="form-group">       <div class="col-sm-12">           <button type="button" class="btn btn-block btn-primary btn-vimeo-edit">Change Video</button>       </div>   </div>   <div class="form-group">       <label class="col-sm-12">Autoplay</label>       <div class="col-sm-12">           <input type="checkbox" id="vimeo-autoplay" />       </div>   </div>   <div class="form-group">       <label class="col-sm-12">Aspect Ratio</label>       <div class="col-sm-12">           <button type="button" class="btn btn-sm btn-default btn-vimeo-169">16:9</button>           <button type="button" class="btn btn-sm btn-default btn-vimeo-43">4:3</button>       </div>   </div></form>');
         form.find(".btn-vimeo-edit").on("click", function(event) {
           event.preventDefault();
           /** @type {(Array<string>|null)} */
           var e = prompt("Please enter Vimeo URL in here:").match(/https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)/);
           if (e && e[1]) {
             keditor.getSettingComponent().find(".embed-responsive-item").attr("src", "https://player.vimeo.com/video/" + e[1] + "?byline=0&portrait=0&badge=0");
           } else {
             alert("Your Vimeo URL is invalid!");
           }
         });
         form.find(".btn-vimeo-169").on("click", function(event) {
           event.preventDefault();
           keditor.getSettingComponent().find(".embed-responsive").removeClass("embed-responsive-4by3").addClass("embed-responsive-16by9");
         });
         form.find(".btn-vimeo-43").on("click", function(event) {
           event.preventDefault();
           keditor.getSettingComponent().find(".embed-responsive").removeClass("embed-responsive-16by9").addClass("embed-responsive-4by3");
         });
         var chkAutoplay = form.find("#vimeo-autoplay");
         chkAutoplay.on("click", function() {
           var $img = keditor.getSettingComponent().find(".embed-responsive-item");
           var _gif = $img.attr("src").replace(/(\?.+)+/, "") + "?byline=0&portrait=0&badge=0&autoplay=" + (chkAutoplay.is(":checked") ? 1 : 0);
           $img.attr("src", _gif);
         });
       },
       showSettingForm : function(form, component, keditor) {
         var src_item = component.find(".embed-responsive-item");
         var chkAutoplay = form.find("#vimeo-autoplay");
         var sideSrc = src_item.attr("src");
         chkAutoplay.prop("checked", -1 !== sideSrc.indexOf("autoplay=1"));
       }
     };
     line.a.components.youtube = {
       init : function(tablixBody, dom, e, n) {
         var sel = e.find("iframe");
         var _normalY = sel.parent();
         n.initIframeCover(sel, _normalY);
       },
       settingEnabled : true,
       settingTitle : "Youtube Settings",
       initSettingForm : function(form, keditor) {
         form.append('<form class="form-horizontal">   <div class="form-group">       <div class="col-sm-12">           <button type="button" class="btn btn-block btn-primary btn-youtube-edit">Change Video</button>       </div>   </div>   <div class="form-group">       <label class="col-sm-12">Autoplay</label>       <div class="col-sm-12">           <input type="checkbox" id="youtube-autoplay" />       </div>   </div>   <div class="form-group">       <label class="col-sm-12">Aspect Ratio</label>       <div class="col-sm-12">           <button type="button" class="btn btn-sm btn-default btn-youtube-169">16:9</button>           <button type="button" class="btn btn-sm btn-default btn-youtube-43">4:3</button>       </div>   </div></form>');
         form.find(".btn-youtube-edit").on("click", function(event) {
           event.preventDefault();
           /** @type {(Array<string>|null)} */
           var e = prompt("Please enter Youtube URL in here:").match(/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&"'>]+)/);
           if (e && e[1]) {
             keditor.getSettingComponent().find(".embed-responsive-item").attr("src", "https://www.youtube.com/embed/" + e[1]);
           } else {
             alert("Your Youtube URL is invalid!");
           }
         });
         form.find(".btn-youtube-169").on("click", function(event) {
           event.preventDefault();
           keditor.getSettingComponent().find(".embed-responsive").removeClass("embed-responsive-4by3").addClass("embed-responsive-16by9");
         });
         form.find(".btn-youtube-43").on("click", function(event) {
           event.preventDefault();
           keditor.getSettingComponent().find(".embed-responsive").removeClass("embed-responsive-16by9").addClass("embed-responsive-4by3");
         });
         var chkAutoplay = form.find("#youtube-autoplay");
         chkAutoplay.on("click", function() {
           var $img = keditor.getSettingComponent().find(".embed-responsive-item");
           var _gif = $img.attr("src").replace(/(\?.+)+/, "") + "?autoplay=" + (chkAutoplay.is(":checked") ? 1 : 0);
           $img.attr("src", _gif);
         });
       },
       showSettingForm : function(form, component, keditor) {
         var src_item = component.find(".embed-responsive-item");
         var chkAutoplay = form.find("#youtube-autoplay");
         var sideSrc = src_item.attr("src");
         chkAutoplay.prop("checked", -1 !== sideSrc.indexOf("autoplay=1"));
       }
     };
   }]);
 });
 
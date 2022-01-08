(this["webpackJsonptrailer-redux"]=this["webpackJsonptrailer-redux"]||[]).push([[0],{41:function(e,t,a){},42:function(e,t,a){},60:function(e,t,a){e.exports=a(87)},71:function(e,t,a){},73:function(e,t,a){},74:function(e,t,a){},75:function(e,t,a){},76:function(e,t,a){},77:function(e,t,a){},78:function(e,t,a){},79:function(e,t,a){},80:function(e,t,a){},81:function(e,t,a){},84:function(e,t,a){},85:function(e,t,a){},86:function(e,t,a){},87:function(e,t,a){"use strict";a.r(t);var n=a(1),c=a.n(n),r=a(32),l=a.n(r),o=a(3),i=a(4),s=a(11),u=a(6),d=a.n(u),m=a(12),p=a(51),v=a(7),f=function(e){var t=arguments.length>1&&void 0!==arguments[1]&&arguments[1];if(t){var a=new Intl.NumberFormat("en-AU",{style:"currency",currency:"AUD"});return a.format(e)}return"$"+Number(e).toLocaleString()},b=function e(t){var a=function(e){return"[object Object]"===Object.prototype.toString.call(e)},n=function(e){return"[object Array]"===Object.prototype.toString.call(e)},c=function(e){return e.attributes?Object(v.a)({id:e.id},e.attributes):e};if(n(t))return t.map((function(t){return e(t)}));if(a(t)){for(var r in t=n(t.data)?Object(i.a)(t.data):a(t.data)?c(Object(v.a)({},t.data)):null===t.data?null:c(t))t[r]=e(t[r]);return t}return t},E=Object(s.b)("api/CallBegan"),h=(Object(s.b)("api/CallSuccess"),Object(s.b)("api/CallFailed"),function(e){var t=e.dispatch;return function(e){return function(){var a=Object(m.a)(d.a.mark((function a(n){var c,r,l,o,i,s,u,m,v,f;return d.a.wrap((function(a){for(;;)switch(a.prev=a.next){case 0:if(console.log(n.type),n.type===E.type){a.next=3;break}return a.abrupt("return",e(n));case 3:if(e(n),c=n.payload,r=c.url,l=c.graphQlQuery,o=c.data,i=c.onStart,s=c.onSuccess,u=c.onError,i&&t({type:i}),a.prev=6,m=void 0,l){a.next=12;break}return a.next=11,fetch(r,{method:"POST",mode:"no-cors",cache:"no-cache",headers:{"Content-Type":"application/json"},redirect:"follow",body:JSON.stringify(o)});case 11:m=a.sent;case 12:if(!l){a.next=17;break}return v=new p.GraphQLClient(r,{}),a.next=16,v.request(l);case 16:m=a.sent;case 17:s&&m&&l&&(f=b(m),t({type:s,payload:f})),a.next=24;break;case 20:a.prev=20,a.t0=a.catch(6),console.log("exception "+a.t0),u&&t({type:u,payload:a.t0.message});case 24:case"end":return a.stop()}}),a,null,[[6,20]])})));return function(e){return a.apply(this,arguments)}}()}}),g={productId:void 0,modelId:void 0,accessoryIds:[],customOptions:[]},y=Object(s.c)({name:"build",initialState:g,reducers:{setCustomOption:function(e,t){var a=e.customOptions.findIndex((function(e){return e.optionId===t.payload.optionId}));-1!==a?e.customOptions[a].optionSelectionId=t.payload.optionSelectionId:e.customOptions.push(t.payload)},addAccessory:function(e,t){e.accessoryIds.push(t.payload)},setProduct:function(e,t){e.productId!==t.payload&&(e.modelId=void 0),e.productId=t.payload},setModel:function(e,t){e.modelId!==t.payload&&(e.accessoryIds=[]),e.modelId=t.payload},removeAccessory:function(e,t){var a=e.accessoryIds.indexOf(t.payload);if(a>-1){var n=e.accessoryIds.splice(a,1);console.log(n)}},buildPosted:function(){}}}),O=y.actions,k=(O.setCustomOption,O.addAccessory),N=O.setProduct,j=O.setModel,C=O.removeAccessory,S=function(e){return e.build.accessoryIds},x=function(e){var t;return null===(t=e.catalog.products)||void 0===t?void 0:t.find((function(t){var a;return t.id===""+(null===(a=e.build)||void 0===a?void 0:a.productId)}))},_=function(e){var t,a;return null===(t=x(e))||void 0===t||null===(a=t.models)||void 0===a?void 0:a.find((function(t){return t.id===""+e.build.modelId}))},w=function(e){return e.build.accessoryIds.map((function(t){return e.catalog.accessories.find((function(e){return e.id===""+t}))}))},I=function(e){return{product:x(e),model:_(e),accessories:w(e)}},F=function(e){var t,a,n=null===(t=_(e))||void 0===t?void 0:t.featured_image,c=null===(a=x(e))||void 0===a?void 0:a.featured_image;return n||c},P=function(e){var t,a,n=(null===(t=x(e))||void 0===t?void 0:t.rrp)||0,c=(null===(a=_(e))||void 0===a?void 0:a.rrp)||0,r=w(e).reduce((function(e,t){return e+((null===t||void 0===t?void 0:t.rrp)||0)}),0);return c?c+r:n||0},A=function(e){return e.catalog.customOptionPickers.map((function(t){return{name:t.option_name,selectedOption:(a=t.id,function(e){var t=e.build.customOptions.find((function(e){return e.optionId===a})),n=null===t||void 0===t?void 0:t.optionSelectionId;if(!e.catalog.customOptionPickersLoading){var c=e.catalog.customOptionPickers.find((function(e){return e.id===a}));return null===c||void 0===c?void 0:c.options.find((function(e){return e.id===n}))}})(e)};var a}))},B=function(e){return{product:x(e),model:_(e),accessories:w(e),image:F(e)}},q=y.reducer,D=Object(s.c)({name:"catalog",initialState:{loading:!1,accessoriesLoading:!1,customOptionPickersLoading:!1,products:[],accessories:[],accessoryCategories:[],customOptionPickers:[]},reducers:{customOptionPickersRequested:function(e,t){e.customOptionPickersLoading=!0},customOptionPickersReceived:function(e,t){t.payload.model&&(e.customOptionPickers=t.payload.model.other_options),e.customOptionPickersLoading=!1},accessoriesRequested:function(e,t){e.accessoriesLoading=!0},accessoriesReceived:function(e,t){e.accessoriesLoading=!1,e.accessories=t.payload.accessories},catalogRequested:function(e,t){e.loading=!0},catalogReceived:function(e,t){console.log(t.payload.products),e.products=t.payload.products,e.loading=!1},categoriesRequested:function(e,t){},categoriesReceived:function(e,t){e.accessoryCategories=t.payload.accessoryCategories}}}),V=function(e){return e.catalog.products},R=function(e){var t;return null===(t=e.catalog.products.find((function(t){return""+e.build.productId===t.id})))||void 0===t?void 0:t.models},L=function(e){return function(t){return t.catalog.accessories.find((function(t){return t.id===""+e}))}},Q=function(e){return e.catalog.accessoryCategories},M=D.reducer,z=Object(s.c)({name:"customer",initialState:{},reducers:{updateDeliveryDetails:function(e,t){return Object(v.a)(Object(v.a)({},e),t.payload)},updateCustomerDetails:function(e,t){return Object(v.a)(Object(v.a)({},e),t.payload)},updateCustomerAddress:function(e,t){e.address=t.payload}}}),T=z.actions,W=T.updateDeliveryDetails,$=T.updateCustomerDetails,H=T.updateCustomerAddress,J=function(e){return e.customer},Y=z.reducer,U={loading:!1,settings:{webhook_url:void 0,require_user_contact_details_upfront:void 0,logo_light:{url:void 0}}},Z=Object(s.c)({name:"settings",initialState:U,reducers:{settingsRequested:function(e,t){e.loading=!0},settingsReceived:function(e,t){e.settings=t.payload.settings,e.loading=!1}}}),G=function(e){return e.settings.settings},K=Z.reducer,X=Object(s.c)({name:"ui",initialState:{builderStep:0},reducers:{nextBuilderStep:function(e,t){e.builderStep++},prevBuilderStep:function(e,t){e.builderStep>0&&e.builderStep--},setBuilderStep:function(e,t){e.builderStep=t.payload}}}),ee=X.actions,te=ee.nextBuilderStep,ae=ee.prevBuilderStep,ne=(ee.setBuilderStep,function(e){return e.ui.builderStep}),ce=X.reducer,re=Object(s.a)({reducer:{catalog:M,build:q,ui:ce,settings:K,customer:Y},middleware:[].concat(Object(i.a)(Object(s.d)()),[h])});re.dispatch((function(e){return e(E({url:"https://camper-configurator-spw7u.ondigitalocean.app/graphql",graphQlQuery:'{\n    products(sort: "rrp") {\n      data {\n        id\n        attributes {\n          name\n          short_description\n          description\n          rrp\n          featured_image {\n            data{\n              id\n              attributes{\n                url\n                width\n                height\n              }\n            }\n          }\n          models(sort: "rrp") {\n            data{\n              id\n              attributes {\n                name\n                short_description\n                description\n                rrp\n                featured_image{\n                  data {\n                    id \n                    attributes{\n                      url\n                    }\n                  }\n                }\n              }\n            }    \n          }\n        }     \n      }\n    }\n  }',onStart:D.actions.catalogRequested.type,onSuccess:D.actions.catalogReceived.type}))})),re.dispatch((function(e){return e(E({url:"https://camper-configurator-spw7u.ondigitalocean.app/graphql",graphQlQuery:"{\n    accessories {\n      data {\n        id\n        attributes{\n          name\n          short_description\n          description\n          rrp\n          featured_image {\n            data{\n              attributes{\n            \t\turl    \n              }\n            }\n          }\n          accessory_categories{\n            data{\n              id\n              attributes{\n                name      \n              }\n            }\n          }\n          option_for {\n            data{\n            \tid  \n            }\n          }\n          included_in {\n            data {\n            \tid  \n            }\n          }        \n      }\n    }   \n  }\n}",onStart:D.actions.accessoriesRequested.type,onSuccess:D.actions.accessoriesReceived.type}))})),re.dispatch((function(e){return e(E({url:"https://camper-configurator-spw7u.ondigitalocean.app/graphql",graphQlQuery:"{\n    accessoryCategories {\n      data {\n      id \n      attributes {\n         name\n         accessories {\n          data {\n          \tid\n            attributes {\n              name\n              description\n              short_description\n              rrp\n              featured_image {\n                data{\n                  id\n                  attributes{\n                  \turl\n                    alternativeText\n                  }\n                }\n                \n              }\n              option_for {\n                data{\n                \tid\n                }\n                \n              }\n            }\n          }\n      }\n      }\n    }\n  }\n  }",onStart:D.actions.categoriesRequested.type,onSuccess:D.actions.categoriesReceived.type}))})),re.dispatch((function(e){return e(E({url:"https://camper-configurator-spw7u.ondigitalocean.app/graphql",graphQlQuery:"{\n    settings: config {\n      data{\n        attributes{\n          webhook_url\n      \t\trequire_user_contact_details_upfront\n          logo_light {\n            data{\n              attributes{\n                url\n              }\n            }\n          }\n        }\n      }\n    }\n  }",onStart:Z.actions.settingsRequested.type,onSuccess:Z.actions.settingsReceived.type}))}));var le=a(8),oe=a(22),ie=a(2),se=a(39),ue=a(15),de=a(35),me=a(24),pe=a(26),ve=a(9),fe=a.n(ve),be=function(e){Object(me.a)(a,e);var t=Object(pe.a)(a);function a(e){var n;Object(ue.a)(this,a),(n=t.call(this,e)).handleChange=function(e){var t=n.props,a=t.disabled,c=t.onChange;a||("checked"in n.props||n.setState({checked:e.target.checked}),c&&c({target:Object(v.a)(Object(v.a)({},n.props),{},{checked:e.target.checked}),stopPropagation:function(){e.stopPropagation()},preventDefault:function(){e.preventDefault()},nativeEvent:e.nativeEvent}))},n.saveInput=function(e){n.input=e};var c="checked"in e?e.checked:e.defaultChecked;return n.state={checked:c},n}return Object(de.a)(a,[{key:"focus",value:function(){this.input.focus()}},{key:"blur",value:function(){this.input.blur()}},{key:"render",value:function(){var e,t=this.props,a=t.prefixCls,n=t.className,r=t.style,l=t.name,o=t.id,i=t.type,s=t.disabled,u=t.readOnly,d=t.tabIndex,m=t.onClick,p=t.onFocus,v=t.onBlur,f=t.autoFocus,b=t.value,E=t.required,h=Object(se.a)(t,["prefixCls","className","style","name","id","type","disabled","readOnly","tabIndex","onClick","onFocus","onBlur","autoFocus","value","required"]),g=Object.keys(h).reduce((function(e,t){return"aria-"!==t.substr(0,5)&&"data-"!==t.substr(0,5)&&"role"!==t||(e[t]=h[t]),e}),{}),y=this.state.checked,O=fe()(a,n,(e={},Object(ie.a)(e,"".concat(a,"-checked"),y),Object(ie.a)(e,"".concat(a,"-disabled"),s),e));return c.a.createElement("span",{className:O,style:r},c.a.createElement("input",Object.assign({name:l,id:o,type:i,required:E,readOnly:u,disabled:s,tabIndex:d,className:"".concat(a,"-input"),checked:!!y,onClick:m,onFocus:p,onBlur:v,onChange:this.handleChange,autoFocus:f,ref:this.saveInput,value:b},g)),c.a.createElement("span",{className:"".concat(a,"-inner")}))}}],[{key:"getDerivedStateFromProps",value:function(e,t){return"checked"in e?Object(v.a)(Object(v.a)({},t),{},{checked:e.checked}):null}}]),a}(n.Component);be.defaultProps={prefixCls:"rc-checkbox",className:"",style:{},type:"checkbox",defaultChecked:!1,onFocus:function(){},onBlur:function(){},onChange:function(){}};var Ee=be;a(71);function he(e){var t;return e.showBackButton&&(t=c.a.createElement("span",{className:"step-back",onClick:function(){return e.onBackClick&&e.onBackClick()}},"< "," ")),c.a.createElement("div",{className:fe()("step-title",{active:e.isActive})},t," ",c.a.createElement("h2",null,e.title))}function ge(){var e,t=Object(oe.h)().id,a=Object(o.b)(),n=Object(o.c)((e=t,function(t){return t.catalog.accessories.filter((function(a){if(t.build.modelId){var n=a.option_for.find((function(e){return e.id===t.build.modelId})),c=a.accessory_categories.find((function(t){return t.id===e}));return n&&c}return!1}))})),r=Object(o.c)(S),l=Object(o.c)(function(e){return function(t){return t.catalog.accessoryCategories.find((function(t){return t.id===e}))}}(t)),i=Object(oe.g)(),s=null===n||void 0===n?void 0:n.map((function(e){return c.a.createElement("div",{className:"accessory-short_description",key:e.id},c.a.createElement("h3",null,e.name),c.a.createElement("p",null,e.short_description),c.a.createElement(Ee,{onChange:function(t){console.log(t),t.target.checked?a(k(e.id)):a(C(e.id))},checked:r.includes(e.id)}),c.a.createElement(le.b,{to:"/accessories/"+e.id},"Read More >"))}));return c.a.createElement("div",null,c.a.createElement(he,{title:"Category: "+(null===l||void 0===l?void 0:l.name)||!1,showBackButton:!0,onBackClick:i.goBack}),s,c.a.createElement(le.b,{className:"primary-button",to:"/3-select-accessories"},"Done"))}var ye=a(13),Oe=a(16);a(73);function ke(e){var t,a,n=Object(o.c)(L(e.id));return c.a.createElement("div",{className:"accessory-details-sidebar"},(null===n||void 0===n||null===(t=n.featured_image)||void 0===t?void 0:t.url)&&c.a.createElement("img",{className:"accessory-detail-image",src:""+(null===n||void 0===n||null===(a=n.featured_image)||void 0===a?void 0:a.url),alt:""}),c.a.createElement("h3",null,null===n||void 0===n?void 0:n.name),(null===n||void 0===n?void 0:n.rrp)&&c.a.createElement("h5",null,"$",null===n||void 0===n?void 0:n.rrp),c.a.createElement("p",null,null===n||void 0===n?void 0:n.description))}a(74),a(75);var Ne=c.a.createContext({openAccordionItem:0,setOpenAccordionItem:void 0});function je(e){var t=c.a.useState(0),a=Object(ye.a)(t,2),n=a[0],r=a[1],l=c.a.Children.map(e.children,(function(e,t){if(c.a.isValidElement(e))return c.a.cloneElement(e,{index:t})}));return c.a.createElement(Ne.Provider,{value:{openAccordionItem:n,setOpenAccordionItem:r}},c.a.createElement("div",{className:"sz-accordion"},l))}function Ce(e){var t,a=Object(n.useRef)(null),r=Object(n.useContext)(Ne),l=r.openAccordionItem,o=r.setOpenAccordionItem,i=e.index===l;return c.a.createElement("div",Object.assign({},e,{className:fe()("accordion-item",{open:i})}),c.a.createElement("div",{className:"accordion-item-header",onClick:function(){return o&&o(i?-1:e.index||0)}},c.a.createElement("h3",{className:"accordion-item-title"},e.title),c.a.createElement("div",{className:"svg-icon-container"},c.a.createElement(Oe.c,null))),c.a.createElement("div",{className:"accordion-content-wrapper",style:i?{maxHeight:null===a||void 0===a||null===(t=a.current)||void 0===t?void 0:t.scrollHeight}:{maxHeight:"0px"}},c.a.createElement("div",{className:"accordion-item-content",ref:a},e.children)))}function Se(e){var t=Object(o.c)(Q),a=Object(o.c)(S),n=Object(o.b)(),r=t.map((function(t){var r=t.accessories.map((function(t){return c.a.createElement("div",{className:"accessory-add-button-wrapper",key:t.id},c.a.createElement("div",{className:"accessory-add-button"},t.featured_image&&c.a.createElement("div",{className:"accessory-button-thumb",onClick:function(){return e.onDetailsClick(t.id)}},c.a.createElement("img",{className:"accessory-thumb",src:""+t.featured_image.url,alt:""})),c.a.createElement("div",{className:"accessory-button-info-wrapper"},c.a.createElement("div",{className:"accessory-button-label",title:t.name,onClick:function(){return e.onDetailsClick(t.id)}},c.a.createElement("span",{className:"accessory-button-title"},(r=t.name,l=44,r.length>l?r.substring(0,l)+"\u2026":r)),c.a.createElement("span",{className:"accessory-button-subtitle"},f(t.rrp||0))),a.find((function(e){return e===t.id}))?c.a.createElement("span",{className:"accessory-button-icon accessory-button-icon-added",onClick:function(){return n(C(t.id))}},c.a.createElement("span",{className:"accessory-button-icon-remove"},c.a.createElement(Oe.h,null)),c.a.createElement("span",{className:"accessory-button-icon-check"},c.a.createElement(Oe.b,null))):c.a.createElement("span",{className:"accessory-button-icon accessory-button-icon-add",onClick:function(){return n(k(t.id))}},c.a.createElement(Oe.a,null)),c.a.createElement("span",{className:"accessory-button-icon accessory-button-icon-more-info",onClick:function(){return e.onDetailsClick(t.id)}},c.a.createElement(Oe.e,null)))));var r,l}));return c.a.createElement(Ce,{key:t.id,title:t.name},r)}),{});return c.a.createElement("div",{className:fe()("accessories-accordion-container")},c.a.createElement("h3",null,"Add Accessories"),c.a.createElement("p",{className:"weak-label"},"Add accessories to create your perfect product"),c.a.createElement(je,null,r))}a(76);function xe(){var e=Object(o.c)(F),t=Object(n.useState)(!1),a=Object(ye.a)(t,2),r=a[0],l=a[1],i=Object(n.useState)("1"),s=Object(ye.a)(i,2),u=s[0],d=s[1];return c.a.createElement("div",{className:"accessories-section"},c.a.createElement("div",{className:"model-image-container"},c.a.createElement("img",{src:""+(null===e||void 0===e?void 0:e.url),alt:""})),c.a.createElement("div",{className:"sidebar accessories-sidebar"},c.a.createElement("div",{className:fe()("sidebar-menu-1",{active:!r})},c.a.createElement(Se,{onDetailsClick:function(e){return t=e,console.log("showing accessory "+t),l(!0),void d(t);var t}})),c.a.createElement("div",{className:fe()("sidebar-menu-2",{active:r})},c.a.createElement("div",{style:{cursor:"pointer"},onClick:function(){return l(!1)}},c.a.createElement(Oe.d,null)," Back"),c.a.createElement(ke,{id:u}))))}a(41);function _e(){var e=Object(oe.h)().id,t=Object(o.c)(L(e)),a=Object(oe.g)();return console.log("acc ",t),c.a.createElement("div",null,c.a.createElement("h3",null,null===t||void 0===t?void 0:t.name),c.a.createElement("h5",null,"$",null===t||void 0===t?void 0:t.rrp),c.a.createElement("p",null,null===t||void 0===t?void 0:t.description),c.a.createElement("button",{className:"primary-button back-button",onClick:a.goBack},"Back"))}var we=a(27);a(42);function Ie(e){var t=Object(o.b)(),a=Object(we.a)(),n=a.register,r=a.getValues,l=a.triggerValidation,i=function(){var a=Object(m.a)(d.a.mark((function a(){var n;return d.a.wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return t(H(r())),a.next=3,l();case 3:n=a.sent,e.onValid(n);case 5:case"end":return a.stop()}}),a)})));return function(){return a.apply(this,arguments)}}();return c.a.createElement(c.a.Fragment,null,c.a.createElement("form",{onChange:i,className:"szForm"},c.a.createElement("fieldset",null,c.a.createElement("legend",null,"Enter your address"),c.a.createElement("label",{htmlFor:"address-line-1"},c.a.createElement("span",{className:"label-text"},"Line 1"),c.a.createElement("input",{id:"address-line-1",name:"address-line-1",placeholder:"11 Smith St",ref:n({required:!0})})),c.a.createElement("label",{htmlFor:"address-line-2"},c.a.createElement("span",{className:"label-text"},"Line 2"),c.a.createElement("input",{id:"address-line-2",name:"address-line-2",placeholder:"",ref:n})),c.a.createElement("label",{htmlFor:"city"},c.a.createElement("span",{className:"label-text"},"City"),c.a.createElement("input",{id:"city",name:"city",placeholder:"Melbourne",ref:n({required:!0})})),c.a.createElement("label",{htmlFor:"country"},c.a.createElement("span",{className:"label-text"},"Country"),c.a.createElement("input",{id:"country",name:"country",defaultValue:"Australia",placeholder:"Australia",ref:n({required:!0})})),c.a.createElement("label",{htmlFor:"state"},c.a.createElement("span",{className:"label-text"},"State"),c.a.createElement("input",{id:"state ",name:"state",placeholder:"VIC",ref:n({required:!0})})))))}var Fe=a(53);a(77);function Pe(){var e=Object(o.c)(x),t=Object(o.c)(_),a=Object(o.c)(w),n=Object(o.c)(A).map((function(e){var t;return c.a.createElement("div",{key:e.name},c.a.createElement("span",null,e.name),c.a.createElement("span",null,null===(t=e.selectedOption)||void 0===t?void 0:t.option_name))})),r=a.map((function(e){return c.a.createElement(le.b,{to:"/accessories/"+(null===e||void 0===e?void 0:e.id),key:null===e||void 0===e?void 0:e.id,className:"accessory"},c.a.createElement("span",null,null===e||void 0===e?void 0:e.name),c.a.createElement("span",null,f((null===e||void 0===e?void 0:e.rrp)||0)))})),l=(null===t||void 0===t?void 0:t.name)?null===t||void 0===t?void 0:t.name:null===e||void 0===e?void 0:e.name;return c.a.createElement("div",{className:"build-box"},c.a.createElement("div",{className:"build-box-left"},c.a.createElement("div",{className:"build-box-icon"},c.a.createElement(Fe.a,null)),c.a.createElement("div",{className:"build-box-text"},c.a.createElement("h3",{className:"build-box-title"},l||"Select Product"),r.length>0&&c.a.createElement("span",{className:"build-box-accessories"},a.length," Accessories"))),c.a.createElement("div",{className:"build-box-price"},c.a.createElement("span",null,f(Object(o.c)(P)))),n)}a(78);function Ae(){var e=Object(o.c)(Q),t=Object(oe.g)(),a=null===e||void 0===e?void 0:e.map((function(e){var t;return c.a.createElement(le.b,{to:"/accessory-categories/"+e.id,className:"category-link",key:e.id},c.a.createElement("div",{className:fe()("category-icon")},c.a.createElement("img",{src:""+(null===(t=e.icon)||void 0===t?void 0:t.url),alt:""}),c.a.createElement("span",null,e.name)))}));return c.a.createElement(c.a.Fragment,null,c.a.createElement(he,{title:"Accessory Categories",showBackButton:!0,onBackClick:t.goBack}),c.a.createElement("div",{className:"category-listing"},a))}function Be(e){var t=Object(o.b)(),a=Object(we.a)({mode:"onChange"}),n=a.register,r=a.errors,l=a.getValues,i=a.triggerValidation,s=function(){var a=Object(m.a)(d.a.mark((function a(){var n;return d.a.wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return t($(l())),a.next=3,i();case 3:n=a.sent,e.onValid(n);case 5:case"end":return a.stop()}}),a)})));return function(){return a.apply(this,arguments)}}();return c.a.createElement(c.a.Fragment,null,c.a.createElement("form",{onChange:s,className:"szForm"},c.a.createElement("fieldset",null,c.a.createElement("legend",null,"Enter your contact details"),c.a.createElement("label",{htmlFor:"firstName"},c.a.createElement("span",{className:"label-text"},"First Name"),c.a.createElement("input",{id:"firstName",name:"firstName",placeholder:"John",ref:n({required:!0})})),c.a.createElement("label",{htmlFor:"surname"},c.a.createElement("span",{className:"label-text"},"Surname"),c.a.createElement("input",{id:"surname",name:"surname",placeholder:"Smith",ref:n({required:!0})})),c.a.createElement("label",{htmlFor:"phone"},c.a.createElement("span",{className:"label-text"},"Phone"),c.a.createElement("input",{id:"phone",name:"phone",placeholder:"0400 000 000",ref:n({required:!0})})),c.a.createElement("label",{htmlFor:"email"},c.a.createElement("span",{className:"label-text"},"Email"),c.a.createElement("input",{id:"email",name:"email",placeholder:"your@email.com",ref:n({required:!0,pattern:{value:/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i,message:"Invalid email address"}})})),r.email&&c.a.createElement("span",null,r.email.message),c.a.createElement("label",{htmlFor:"postcode"},c.a.createElement("span",{className:"label-text"},"Postcode"),c.a.createElement("input",{id:"postcode ",name:"postcode",placeholder:"3000",ref:n({required:!0})})),c.a.createElement("label",{htmlFor:"newsletter",className:"no-bg"},c.a.createElement("input",{id:"newsletter",type:"checkbox",name:"newsletter",defaultChecked:!0,ref:n}),"Sign up for special offers and promotions"))))}function qe(e){var t=Object(o.b)(),a=Object(we.a)({mode:"onChange",reValidateMode:"onChange"}),n=a.register,r=a.triggerValidation,l=a.getValues,i=function(){var a=Object(m.a)(d.a.mark((function a(){var n;return d.a.wrap((function(a){for(;;)switch(a.prev=a.next){case 0:return t(W(l())),a.next=3,r();case 3:n=a.sent,e.onValid(n);case 5:case"end":return a.stop()}}),a)})));return function(){return a.apply(this,arguments)}}();return c.a.createElement(c.a.Fragment,null,c.a.createElement("form",{onChange:i,className:"szForm"},c.a.createElement("fieldset",null,c.a.createElement("legend",null,"Delivery Method"),c.a.createElement("label",{htmlFor:"delivery",className:"no-bg radio"},c.a.createElement("input",{id:"delivery",name:"deliverymethod",type:"radio",value:"delivery",ref:n}),c.a.createElement("span",{className:"label-text"},"Delivery")),c.a.createElement("label",{htmlFor:"pickup",className:"no-bg radio"},c.a.createElement("input",{id:"pickup",name:"deliverymethod",type:"radio",value:"pickup",ref:n({validate:function(){return""!==l().deliveryMethod}})}),c.a.createElement("span",{className:"label-text"},"Pick Up"))),c.a.createElement("fieldset",null,c.a.createElement("legend",null,"Choose your dealer"),c.a.createElement("select",{name:"dealer",id:"dealer",ref:n},c.a.createElement("option",{value:"Head Office"},"Head Office"),c.a.createElement("option",{value:"QLD Dealer"}," QLD Dealer"),c.a.createElement("option",{value:"NSW Dealer"}," NSW Dealer")))))}a(79);function De(){var e,t=Object(oe.h)().id,a=Object(o.c)(function(e){return function(t){if(t.catalog.products&&0!==t.catalog.products.length)return t.catalog.products.reduce((function(t,a){var n,c=null===(n=a.models)||void 0===n?void 0:n.find((function(t){return console.log(typeof t.id,typeof e),t.id===""+e}));return c||t}),void 0)}}(parseInt(t))),n=Object(oe.g)();return c.a.createElement(c.a.Fragment,null,c.a.createElement("div",{className:"model-details-section"},c.a.createElement("div",{className:"model-image-container"},"WIP",a&&c.a.createElement("img",{src:""+(null===a||void 0===a||null===(e=a.featured_image)||void 0===e?void 0:e.url),alt:""})),c.a.createElement("div",{className:"model-details"},c.a.createElement("h3",null,a&&(null===a||void 0===a?void 0:a.name)),c.a.createElement("h5",null,"$",a&&a.rrp),c.a.createElement("p",null,a&&a.description))),c.a.createElement("button",{onClick:n.goBack},"Back"))}a(80);function Ve(e){var t,a=Object(o.b)(),r=Object(o.c)(R),l=Object(o.c)(_),i=Object(o.c)(I),s=Object(o.c)(G);return Object(n.useEffect)((function(){(null===r||void 0===r?void 0:r.find((function(e){return e.id===(null===l||void 0===l?void 0:l.id)})))&&e.onValid(!0)})),r&&(t=r.map((function(t){var n,r;return c.a.createElement("div",{className:fe()("product",{selected:(null===l||void 0===l?void 0:l.id)===t.id}),key:t.id,onClick:function(){var n,c;a(j(t.id)),console.log("called"),e.onValid(!0),(null===s||void 0===s?void 0:s.webhook_url)&&a((n=null===s||void 0===s?void 0:s.webhook_url,c=i,function(e){return console.log("webkoook"),e(E({url:n,data:c}))}))}},c.a.createElement("div",{className:"product-thumb-wrapper"},(null===(n=t.featured_image)||void 0===n?void 0:n.url)&&c.a.createElement("img",{className:"product-thumb",src:""+(null===(r=t.featured_image)||void 0===r?void 0:r.url),alt:t.name})),c.a.createElement("div",{className:"select-product-details"},c.a.createElement("h3",{className:"product-title"},t.name),c.a.createElement("p",{className:"product-short_description"},t.short_description),c.a.createElement("div",{className:"product-bottom-line"},t.rrp&&c.a.createElement("h4",{className:"product-price"},"Starts at ",f(t.rrp)),c.a.createElement(le.c,{to:"/select-model/".concat(t.id),className:"secondary-link"},"See Specs"))))}))),c.a.createElement("div",null,c.a.createElement("div",{className:"product-listing"},t))}var Re=a(92);a(81);function Le(){var e,t=Object(oe.h)().id,a=Object(o.c)(function(e){return function(t){if(t.catalog.products&&0!==t.catalog.products.length)return t.catalog.products.find((function(t){return console.log(typeof t.id,typeof e),t.id===e}));console.log("no prod found",t.catalog.products)}}(t)),n=Object(oe.g)();return c.a.createElement(c.a.Fragment,null,c.a.createElement("div",{className:"product-details-section"},"WIP",c.a.createElement("div",{className:"model-image-container"},a&&c.a.createElement("img",{src:""+(null===a||void 0===a||null===(e=a.featured_image)||void 0===e?void 0:e.url),alt:""})),c.a.createElement("div",{className:"product-details"},c.a.createElement("h3",null,a&&(null===a||void 0===a?void 0:a.name)),c.a.createElement("h5",null,"$",a&&a.rrp),c.a.createElement(Re.a,null,(null===a||void 0===a?void 0:a.description)+""))),c.a.createElement("button",{onClick:n.goBack},"Back"))}a(84);function Qe(e){var t,a=Object(o.b)(),r=Object(o.c)(V),l=Object(o.c)(x);return Object(n.useEffect)((function(){r.find((function(e){return e.id===(null===l||void 0===l?void 0:l.id)}))&&e.onValid(!0)})),r&&(t=r.map((function(e){var t,n;return c.a.createElement("div",{className:fe()("product",{selected:(null===l||void 0===l?void 0:l.id)===e.id}),key:e.id,onClick:function(){a(N(e.id))}},c.a.createElement("div",{className:"product-thumb-wrapper"},(null===(t=e.featured_image)||void 0===t?void 0:t.url)&&c.a.createElement("img",{className:"product-thumb",alt:e.name,src:null===(n=e.featured_image)||void 0===n?void 0:n.url})),c.a.createElement("div",{className:"select-product-details"},c.a.createElement("h3",{className:"product-title"},e.name),c.a.createElement("p",{className:"product-short_description"},e.short_description),c.a.createElement("div",{className:"product-bottom-line"},e.rrp&&c.a.createElement("h4",{className:"product-price"},"Starts at ",f(e.rrp)),c.a.createElement(le.c,{to:"/select-product/".concat(e.id),className:"secondary-link"},"View Specs"))))}))),c.a.createElement("div",null,c.a.createElement("div",{className:"product-listing"},t))}a(85);function Me(){var e=Object(o.c)(x),t=Object(o.c)(_),a=Object(o.c)(w),n=Object(o.c)(F),r=a.map((function(e){return c.a.createElement(le.b,{to:"/accessories/"+(null===e||void 0===e?void 0:e.id),key:null===e||void 0===e?void 0:e.id,className:"accessory"},c.a.createElement("span",null,null===e||void 0===e?void 0:e.name),c.a.createElement("span",null,f((null===e||void 0===e?void 0:e.rrp)||0)))}));return c.a.createElement("div",{className:"thankyou-wrapper"},c.a.createElement("h1",{className:"h1"},"Thank you for your enquiry"),c.a.createElement("h3",{className:"thankyou-productname"},c.a.createElement("span",{className:"thankyou-prod-name"},null===e||void 0===e?void 0:e.name)," ",null===t||void 0===t?void 0:t.name),r.length>0&&c.a.createElement("span",{className:"thankyou-accessories"},"With ",a.length," Accessories"),c.a.createElement("div",{className:"thankyou-product-image"},c.a.createElement("img",{src:""+(null===n||void 0===n?void 0:n.url),alt:""})),c.a.createElement("div",{className:"thankyou-box-price"},"Total ",c.a.createElement("span",null,f(Object(o.c)(P)))),c.a.createElement("div",{className:"thankyou-buttons"},c.a.createElement("button",{className:"outline-button secondary"},c.a.createElement(Oe.g,null)," ",c.a.createElement("span",null,"Email Me a Copy")),c.a.createElement("button",{className:"primary-button"},c.a.createElement(Oe.f,null)," ",c.a.createElement("span",null,"Checkout"))))}var ze=function(e){var t=c.a.Children.toArray(e.children);return c.a.createElement(c.a.Fragment,null,c.a.createElement(We,{path:"/:currentPath",steps:t,currentStep:e.currentStep}))},Te=function(e){var t=e.onValid,a=e.children;return Object(n.useEffect)((function(){c.a.isValidElement(a)&&t(!0)})),c.a.isValidElement(a)?a:a(t)};function We(e){e.currentPath;var t=e.steps,a=e.currentStep,r=Object(o.b)(),l=Object(n.useState)(!1),i=Object(ye.a)(l,2),s=i[0],u=i[1],d=Object(n.useState)(-2),m=Object(ye.a)(d,2),p=m[0],v=m[1],f=a;p!==f&&(u(!1),v(f));var b=f>0&&t[f-1].props,E=f<t.length-1&&t[f+1].props;if(f<0)return c.a.createElement($e,{path:t[0].props.path});var h=t.map((function(e,t){return c.a.createElement(he,{title:t+1+". "+e.props.title,isActive:f===t,key:t})}));return c.a.createElement("div",null,c.a.createElement("div",{className:"step-title-container"},h),c.a.cloneElement(t[f],{onValid:function(e){u(e)}}),c.a.createElement("footer",{className:"wizard-footer"},c.a.createElement(He,{className:fe()("back-button","secondary-button",{disabled:!b}),onClick:function(){return r(ae())},title:b.description},"Back"),c.a.createElement(He,{className:fe()("primary-button",{disabled:!s}),onClick:function(){return r(te())},title:E.description},"Next")))}function $e(e){return c.a.createElement(oe.a,{to:e.path,noThrow:!0})}function He(e){var t=e.path,a=Object(se.a)(e,["path"]);return c.a.createElement(le.b,Object.assign({to:"../".concat(t),className:t?"btn btn-primary":"invisible"},a))}var Je=function(){var e=Object(o.c)(G),t=Object(o.c)(ne),a=Object(v.a)(Object(v.a)({},Object(o.c)(B)),{},{customer:Object(o.c)(J)});return c.a.createElement("div",{className:"app"},c.a.createElement("button",{onClick:function(){return function(){var e;window.szReactPlugin&&fetch(null===(e=window.szReactPlugin)||void 0===e?void 0:e.email_endpoint,{method:"POST",headers:{Accept:"application/json, text/plain, */*","Content-Type":"application/json"},body:JSON.stringify(a)}).then((function(e){return e.json()})).then((function(e){e&&console.log(e)})).catch((function(e){console.log("[WP Pageviews Plugin]"),console.error(e)}))}()}},"Send Mail"),c.a.createElement(le.a,null,c.a.createElement("div",{className:"app-container"},c.a.createElement("div",{className:"primary-container"},c.a.createElement("main",null,c.a.createElement("h1",{className:"small-caps"},"Configure Your Camper"),c.a.createElement(Pe,null),c.a.createElement(oe.d,null,c.a.createElement(oe.b,{path:"/select-model/:id"},c.a.createElement(De,null)),c.a.createElement(oe.b,{path:"/select-product/:id"},c.a.createElement(Le,null)),c.a.createElement(oe.b,{path:"/accessory-categories/:id"},c.a.createElement(ge,null)),c.a.createElement(oe.b,{path:"/accessory-categories/"},c.a.createElement(Ae,null)),c.a.createElement(oe.b,{path:"/accessories/:id"},c.a.createElement(_e,null)),c.a.createElement(oe.b,{path:"/"},c.a.createElement(ze,{currentStep:t},(null===e||void 0===e?void 0:e.require_user_contact_details_upfront)&&c.a.createElement(Te,{path:"6-address-details",title:"Your Details"},(function(e){return c.a.createElement(Ie,{onValid:e})})),c.a.createElement(Te,{path:"1-select-product",title:"Select Product"},(function(e){return c.a.createElement(Qe,{onValid:e})})),c.a.createElement(Te,{path:"2-select-model",title:"Select Model"},(function(e){return c.a.createElement(Ve,{onValid:e})})),c.a.createElement(Te,{path:"3-add-accessories",title:"Add Accessories"},c.a.createElement(xe,null)),!(null===e||void 0===e?void 0:e.require_user_contact_details_upfront)&&c.a.createElement(Te,{path:"5-contact-details",title:"Your Details"},(function(e){return c.a.createElement(Be,{onValid:e})})),c.a.createElement(Te,{path:"4-delivery-details",title:"Delivery Details"},(function(e){return c.a.createElement(qe,{onValid:e})})),c.a.createElement(Te,{path:"6-address-details",title:"Your Address"},(function(e){return c.a.createElement(Ie,{onValid:e})})),c.a.createElement(Te,{path:"thankyou",title:"Confirmation"},c.a.createElement(Me,null))))))))))};a(86),Boolean("localhost"===window.location.hostname||"[::1]"===window.location.hostname||window.location.hostname.match(/^127(?:\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}$/));l.a.render(c.a.createElement(c.a.StrictMode,null,c.a.createElement(o.a,{store:re},c.a.createElement(Je,null))),document.getElementById("sz-root")),"serviceWorker"in navigator&&navigator.serviceWorker.ready.then((function(e){e.unregister()})).catch((function(e){console.error(e.message)}))}},[[60,1,2]]]);
//# sourceMappingURL=main.9ae7e417.chunk.js.map
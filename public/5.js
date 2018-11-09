webpackJsonp([5],{

/***/ "./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/views/system/admin.vue":
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
    mounted: function mounted() {
        this.getList();
        this.getGroupList();
    },
    data: function data() {
        return {
            tableData: [],
            form: {
                page: 1,
                pageSize: 20
            },
            addNewDialog: false,
            saveForm: {
                id: '',
                username: '',
                password: '',
                groups: [],
                status: true
            },
            totalItems: 0,
            groups: [],
            auth: {},
            rulesForm: {
                username: [{ required: true, message: '请输入用户名称', trigger: 'blur' }],
                realname: [{ required: true, message: '请输入真实姓名', trigger: 'blur' }],
                groups: [{ required: true, message: '请选择用户组', trigger: 'blur' }]
            }
        };
    },

    methods: {
        onSearch: function onSearch() {
            this.form.page = 1;
            this.getList();
        },
        handleSizeChange: function handleSizeChange(size) {
            this.form.pageSize = size;
            this.getList();
        },
        handleCurrentChange: function handleCurrentChange(page) {
            this.form.page = page;
            this.getList();
        },
        onSubmit: function onSubmit() {
            var _this = this;

            this.$refs['saveForm'].validate(function (valid) {
                if (valid) {
                    if (typeof _this.saveForm.password === 'undefined') {
                        _this.saveForm.password = '';
                    }
                    if (!_this.saveForm.id && _this.saveForm.password.length < 6) {
                        _this.$message({
                            message: '请输入不少于6位的密码',
                            type: 'error'
                        });

                        return;
                    }
                    _this.$http.post('/api/system/admin/save', _this.saveForm).then(function (res) {
                        if (res.error === 0) {
                            _this.$message({
                                message: '保存成功',
                                type: 'success'
                            });
                            _this.addNewDialog = false;
                            _this.getList();
                        } else {
                            _this.$message({
                                message: res.msg,
                                type: 'error'
                            });
                        }
                    });
                } else {
                    console.log('error submit!!');
                    return false;
                }
            });
        },
        getGroupList: function getGroupList() {
            var _this2 = this;

            this.$http.get('/api/system/group/list', { status: 1 }).then(function (res) {
                _this2.groups = res.data.list;
            });
        },
        getList: function getList() {
            var _this3 = this;

            this.$http.get('/api/system/admin/list', this.form).then(function (res) {
                _this3.tableData = res.data.data;
                _this3.totalItems = res.data.total;
                _this3.auth = res.data.auth;
            });
        },
        handleAdd: function handleAdd() {
            this.addNewDialog = true;
            if (typeof this.$refs['saveForm'] !== 'undefined') this.$refs['saveForm'].resetFields();
        },
        editRow: function editRow(row) {
            this.addNewDialog = true;
            if (typeof this.$refs['saveForm'] !== 'undefined') this.$refs['saveForm'].resetFields();

            this.saveForm = {
                id: row.id,
                username: row.username,
                groups: row.groups,
                realname: row.realname,
                mobile: row.mobile,
                email: row.email,
                status: row.status === 1
            };
        }
    }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-47f6e322\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/views/system/admin.vue":
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    [
      _c(
        "el-form",
        { attrs: { inline: true, model: _vm.form, size: "small" } },
        [
          _c(
            "el-form-item",
            { attrs: { label: "ID" } },
            [
              _c("el-input", {
                attrs: { placeholder: "ID" },
                model: {
                  value: _vm.form.id,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "id", $$v)
                  },
                  expression: "form.id"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "el-form-item",
            { attrs: { label: "登录名" } },
            [
              _c("el-input", {
                attrs: { placeholder: "请输入登录名" },
                model: {
                  value: _vm.form.username,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "username", $$v)
                  },
                  expression: "form.username"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "el-form-item",
            { attrs: { label: "真实姓名" } },
            [
              _c("el-input", {
                attrs: { placeholder: "请输入真实姓名" },
                model: {
                  value: _vm.form.realname,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "realname", $$v)
                  },
                  expression: "form.realname"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "el-form-item",
            { attrs: { label: "手机号" } },
            [
              _c("el-input", {
                attrs: { placeholder: "请输入手机号" },
                model: {
                  value: _vm.form.mobile,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "mobile", $$v)
                  },
                  expression: "form.mobile"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "el-form-item",
            { attrs: { label: "邮箱" } },
            [
              _c("el-input", {
                attrs: { placeholder: "请输入邮箱" },
                model: {
                  value: _vm.form.email,
                  callback: function($$v) {
                    _vm.$set(_vm.form, "email", $$v)
                  },
                  expression: "form.email"
                }
              })
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "el-form-item",
            [
              _c(
                "el-button",
                { attrs: { type: "primary" }, on: { click: _vm.onSearch } },
                [_vm._v("查询")]
              )
            ],
            1
          )
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "el-row",
        [
          _vm.auth.canAdd
            ? _c(
                "el-button",
                {
                  attrs: { type: "primary", size: "small" },
                  on: { click: _vm.handleAdd }
                },
                [_vm._v("新增")]
              )
            : _vm._e()
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "el-table",
        { attrs: { data: _vm.tableData } },
        [
          _c("el-table-column", {
            attrs: { prop: "id", label: "ID", width: "80" }
          }),
          _vm._v(" "),
          _c("el-table-column", {
            attrs: { prop: "username", label: "用户名" }
          }),
          _vm._v(" "),
          _c("el-table-column", {
            attrs: { prop: "realname", label: "真实姓名" }
          }),
          _vm._v(" "),
          _c("el-table-column", { attrs: { prop: "mobile", label: "手机号" } }),
          _vm._v(" "),
          _c("el-table-column", { attrs: { prop: "email", label: "邮箱" } }),
          _vm._v(" "),
          _c("el-table-column", {
            attrs: { label: "用户状态", width: "150" },
            scopedSlots: _vm._u([
              {
                key: "default",
                fn: function(scope) {
                  return [
                    scope.row.status == 1
                      ? _c(
                          "el-tag",
                          { attrs: { type: "success", size: "small" } },
                          [_vm._v("正常")]
                        )
                      : _vm._e(),
                    _vm._v(" "),
                    scope.row.status == 0
                      ? _c(
                          "el-tag",
                          { attrs: { type: "info", size: "small" } },
                          [_vm._v("禁用")]
                        )
                      : _vm._e()
                  ]
                }
              }
            ])
          }),
          _vm._v(" "),
          _c("el-table-column", {
            attrs: { prop: "last_login", label: "最后登录时间" }
          }),
          _vm._v(" "),
          _c("el-table-column", {
            attrs: { prop: "last_ip", label: "登录IP" }
          }),
          _vm._v(" "),
          _c("el-table-column", {
            attrs: { prop: "create_time", label: "创建时间" }
          }),
          _vm._v(" "),
          _c("el-table-column", {
            attrs: { fixed: "right", label: "操作", width: "100" },
            scopedSlots: _vm._u([
              {
                key: "default",
                fn: function(scope) {
                  return [
                    _vm.auth.canEdit
                      ? _c(
                          "el-button",
                          {
                            attrs: { type: "text", size: "small" },
                            on: {
                              click: function($event) {
                                _vm.editRow(scope.row)
                              }
                            }
                          },
                          [_vm._v("编辑")]
                        )
                      : _vm._e()
                  ]
                }
              }
            ])
          })
        ],
        1
      ),
      _vm._v(" "),
      _c("br"),
      _vm._v(" "),
      _c(
        "el-row",
        [
          _c(
            "el-col",
            { attrs: { span: 13, offset: 11 } },
            [
              _c("el-pagination", {
                attrs: {
                  background: "",
                  "current-page": _vm.form.page,
                  "page-sizes": [25, 50, 100],
                  "page-size": _vm.form.pageSize,
                  layout: "total, sizes, prev, pager, next, jumper",
                  total: _vm.totalItems
                },
                on: {
                  "size-change": _vm.handleSizeChange,
                  "current-change": _vm.handleCurrentChange
                }
              })
            ],
            1
          )
        ],
        1
      ),
      _vm._v(" "),
      _c("br"),
      _vm._v(" "),
      _c(
        "el-dialog",
        {
          attrs: {
            title: "新增/修改管理员",
            visible: _vm.addNewDialog,
            width: "35%"
          },
          on: {
            "update:visible": function($event) {
              _vm.addNewDialog = $event
            }
          }
        },
        [
          _c(
            "el-form",
            {
              ref: "saveForm",
              attrs: {
                model: _vm.saveForm,
                "label-width": "100px",
                size: "small",
                rules: _vm.rulesForm
              }
            },
            [
              _c(
                "el-form-item",
                { attrs: { label: "登录名", prop: "username" } },
                [
                  _c("el-input", {
                    staticStyle: { width: "50%" },
                    model: {
                      value: _vm.saveForm.username,
                      callback: function($$v) {
                        _vm.$set(_vm.saveForm, "username", $$v)
                      },
                      expression: "saveForm.username"
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "el-form-item",
                { attrs: { label: "密码", prop: "password" } },
                [
                  _c("el-input", {
                    staticStyle: { width: "50%" },
                    model: {
                      value: _vm.saveForm.password,
                      callback: function($$v) {
                        _vm.$set(_vm.saveForm, "password", $$v)
                      },
                      expression: "saveForm.password"
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "el-form-item",
                { attrs: { label: "用户组", prop: "groups" } },
                [
                  _c(
                    "el-select",
                    {
                      staticStyle: { width: "50%" },
                      attrs: { multiple: "", placeholder: "请选择" },
                      model: {
                        value: _vm.saveForm.groups,
                        callback: function($$v) {
                          _vm.$set(_vm.saveForm, "groups", $$v)
                        },
                        expression: "saveForm.groups"
                      }
                    },
                    _vm._l(_vm.groups, function(item) {
                      return _c("el-option", {
                        key: item.id,
                        attrs: { label: item.title, value: item.id }
                      })
                    })
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "el-form-item",
                { attrs: { label: "真实姓名", prop: "realname" } },
                [
                  _c("el-input", {
                    staticStyle: { width: "50%" },
                    model: {
                      value: _vm.saveForm.realname,
                      callback: function($$v) {
                        _vm.$set(_vm.saveForm, "realname", $$v)
                      },
                      expression: "saveForm.realname"
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "el-form-item",
                { attrs: { label: "手机号", prop: "mobile" } },
                [
                  _c("el-input", {
                    staticStyle: { width: "50%" },
                    model: {
                      value: _vm.saveForm.mobile,
                      callback: function($$v) {
                        _vm.$set(_vm.saveForm, "mobile", $$v)
                      },
                      expression: "saveForm.mobile"
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "el-form-item",
                { attrs: { label: "邮箱", prop: "email" } },
                [
                  _c("el-input", {
                    staticStyle: { width: "50%" },
                    model: {
                      value: _vm.saveForm.email,
                      callback: function($$v) {
                        _vm.$set(_vm.saveForm, "email", $$v)
                      },
                      expression: "saveForm.email"
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "el-form-item",
                { attrs: { label: "状态", prop: "status" } },
                [
                  _c("el-switch", {
                    attrs: { "active-text": "正常", "inactive-text": "禁用" },
                    model: {
                      value: _vm.saveForm.status,
                      callback: function($$v) {
                        _vm.$set(_vm.saveForm, "status", $$v)
                      },
                      expression: "saveForm.status"
                    }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "el-form-item",
                [
                  _c(
                    "el-button",
                    { attrs: { type: "primary" }, on: { click: _vm.onSubmit } },
                    [_vm._v("保存")]
                  ),
                  _vm._v(" "),
                  _c(
                    "el-button",
                    {
                      on: {
                        click: function($event) {
                          _vm.addNewDialog = false
                        }
                      }
                    },
                    [_vm._v("取消")]
                  )
                ],
                1
              )
            ],
            1
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-47f6e322", module.exports)
  }
}

/***/ }),

/***/ "./resources/assets/js/views/system/admin.vue":
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__("./node_modules/vue-loader/lib/component-normalizer.js")
/* script */
var __vue_script__ = __webpack_require__("./node_modules/babel-loader/lib/index.js?{\"cacheDirectory\":true,\"presets\":[[\"env\",{\"modules\":false,\"targets\":{\"browsers\":[\"> 2%\"],\"uglify\":true}}]],\"plugins\":[\"transform-object-rest-spread\",[\"transform-runtime\",{\"polyfill\":false,\"helpers\":false}]]}!./node_modules/vue-loader/lib/selector.js?type=script&index=0!./resources/assets/js/views/system/admin.vue")
/* template */
var __vue_template__ = __webpack_require__("./node_modules/vue-loader/lib/template-compiler/index.js?{\"id\":\"data-v-47f6e322\",\"hasScoped\":false,\"buble\":{\"transforms\":{}}}!./node_modules/vue-loader/lib/selector.js?type=template&index=0!./resources/assets/js/views/system/admin.vue")
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/views/system/admin.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-47f6e322", Component.options)
  } else {
    hotAPI.reload("data-v-47f6e322", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});
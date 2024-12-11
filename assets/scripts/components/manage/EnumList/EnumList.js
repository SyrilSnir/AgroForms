const $ = window.$;
export default class EnumList {
  constructor(selector) {
    const $container = $(selector);
    this.$addEnumFieldButton = $container.find(".enum-field-add-button");
    this.$enumList = $container.find(".attributes-enum-table tbody");
    this.$enumFieldName = $container.find(".enum-field-name");
    this.$enumFieldNameEng = $container.find(".enum-field-name-eng");
    this.$enumFieldValue = $container.find(".enum-field-value");
    this.$setDefaultButton = $("#set-default-value");
    this.$defaultValueSelector = $("#default-value-selector");
    this.enumsArray = [];
    this.defaultValuesArray = [];
  }
  init() {
    this.defaultValuesArray.push({
      name: "не задано",
      value: null,
    });
    document.querySelectorAll("tr.w3").forEach((el) => {
      this.defaultValuesArray.push({
        name: el.querySelector(".element-name").textContent,
        value: el.querySelector(".element-value").textContent,
      });
    });
    this.$addEnumFieldButton.on("click", this.addEnumeFieldHandler.bind(this));
    this.$setDefaultButton.on("click", this.setDefaultEventHandler.bind(this));
    this.$enumList.on(
      "click",
      ".delete-enum-field",
      this.deleteEnumFieldHandler.bind(this)
    );
    this.initDelaultSelector();
  }
  addEnumeFieldHandler() {
    const name = this.$enumFieldName.val();
    const nameEng = this.$enumFieldNameEng.val();
    const value = this.$enumFieldValue.val();
    const index = this.$enumList.find("tr").length + 1;
    const template = `<tr data-number="${index}">
                            <td>${index}.</td>
                            <td class="attribute-enum-name">${name}</td>
                            <td class="attribute-enum-name">${nameEng}</td>
                            <td class="attribute-enum-value">${value}</td>
                            <td>    
                                <a class="btn btn-app delete-enum-field">
                                    <i class="fas fa-times"></i>Удалить
                                </a> 
                            </td>
                        </tr>`;
    if (name.trim() !== "" && value.trim() !== "") {
      this.enumsArray.push({
        name: name,
        name_eng: nameEng,
        value: value,
      });
      this.$enumList.append(template);
    }
  }
  deleteEnumFieldHandler(e) {
    const $targetRow = $(e.target).closest("tr");
    let lastRow = false;
    if ($targetRow.next("tr").length == 0) {
      lastRow = true;
    }
    let arrayIndex = $targetRow.data("number") - 1;
    this.enumsArray.splice(arrayIndex, 1);
    $targetRow.remove();
    if (!lastRow) {
      this.indexRerender();
    }
  }

  setDefaultEventHandler() {
    const val = this.$defaultValueSelector.find("option:selected").val();
    const fieldId = this.$setDefaultButton.data("field");
    const fd = new FormData();
    fd.append("defaultValue", val);
    fd.append("fieldId", fieldId);
    fetch("/api/fields/set-default", {
      method: "POST",
      body: fd,
    }).then((res) => {
      console.log(res.data);
    });
  }

  initDelaultSelector() {
    this.defaultValuesArray.forEach((el) => {
      const template = `<option value="${el.value}">${el.name}</option>`;
      this.$defaultValueSelector.append(template);
    });
    const defVal = this.$defaultValueSelector.data("default");
    this.$defaultValueSelector
      .find(`option[value="${defVal}"]`)
      .prop("selected", "selected");
  }
  indexRerender() {
    const $trs = this.$enumList.find("tr");
    $trs.each(function (index, tr) {
      $(tr).data("number", index + 1);
      $(tr)
        .find("td:first")
        .text(index + 1);
    });
  }
}

import axios from "axios";
import FieldParams from "./components/manage/FieldParams";
import EnumList from "./components/manage/EnumList";
import FormManager from "./components/manage/Requests/FormManager";

const $ = window.$;
const managerActivateLink = document.getElementById("get-activare-link");
const exportCatalogLink = document.getElementById("catalog-excel");
const getFormRequestButton = document.getElementById("get-form-request");
const fieldsConfig = document.getElementById("fields-config");
const modalRequestInfo = document.getElementById("modal-request__information");
const ruleCreateLink = document.getElementById("create-new-rule");
const createUserForm = $("#user-create");
const requestSelector = $("#request-list");

if (requestSelector) {
  requestSelector.on("change", (e) => {
    const dataType = $(e.target).find(":selected").data("type");
    if (dataType !== 11) {
      $("#send").show();
      $("#send-app").hide();
    } else {
      $("#send-app").show();
      $("#send").hide();
    }
  });
}

if (fieldsConfig) {
  const fieldParams = new FieldParams();
  const enumList = new EnumList("#attributes-enum-list");
  enumList.init();
}

if (managerActivateLink) {
  managerActivateLink.addEventListener("click", managerActivateHandler);
}

if (exportCatalogLink) {
  exportCatalogLink.addEventListener("click", exportCatalogHandler);
}

if (getFormRequestButton) {
  getFormRequestButton.addEventListener("click", getFormRequestHandler);
}

if (modalRequestInfo) {
  $(modalRequestInfo).on("show.bs.modal", (e) => {
    let modalRequestContent = $("#modal-request__content");
    let requestId = $(e.relatedTarget).data("request");
    modalRequestContent.html("");
    $.get(
      "/panel/member/requests/get-reject-info",
      {
        id: requestId,
      },
      (data) => {
        modalRequestContent.html(data);
      }
    );
  });
}

if (createUserForm) {
  const manId = createUserForm.data("manager");
  console.log(manId);
  const userTypeSelector = $("#usermanageform-usertype").add(
    "#adminform-usertype"
  );
  userTypeSelector.on("change", (e) => {
    if (manId == e.target.value) {
      $("#roles-list").removeClass("hide");
      console.log("Медия менеджер");
    } else {
      $("#roles-list").addClass("hide");
    }
  });
}

if (ruleCreateLink) {
  ruleCreateLink.addEventListener("click", createLinkHandler);
}

function managerActivateHandler(e) {
  const userId = e.target.getAttribute("data-user");
  axios
    .get("/api/user/get-activate-link", {
      params: {
        id: userId,
      },
    })
    .then((response) => {
      const link = response.data;
      $("#activate-link").html(link).attr("href", link);
      $("#show-activate-link").modal();
    });
}

function getFormRequestHandler(e) {
  const selectedOption = document.querySelector(
    '[name="requests-list"] option:checked'
  );
  let selectedValue = selectedOption.value;
  let contractId = getFormRequestButton.dataset.contract;
  location.href =
    "/panel/member/requests/create?formId=" +
    selectedValue +
    "&contractId=" +
    contractId;
}

function createLinkHandler(e) {
  e.preventDefault();
  const link = e.currentTarget;
  const formSelector = document.getElementById("frm-id");
  const exSelector = document.getElementById("ex-id");
  const formId = formSelector.value;
  const exId = exSelector.value;
  const roleId = link.dataset.role;
  let queryString = `?roleId=${roleId}`;
  if (formId) {
    queryString += `&formId=${formId}`;
  } else if (exId) {
    queryString += `&exhibitionId=${exId}`;
  }
  location.href = link.href + queryString;
}

function exportCatalogHandler(e) {
  e.preventDefault();
  const exhibitionSelector = document.getElementById(
    "catalogloadform-exhibitionid"
  );
  const link = e.currentTarget;
  // console.log('Catalog export',link.href,exhibitionSelector.value);
  location.href = `${link.href}?exhibitionId=${exhibitionSelector.value}`;
}

const formManager = new FormManager();

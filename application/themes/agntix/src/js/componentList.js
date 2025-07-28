const custom_container = $(".custom_container");
const blurredImg = $(".blurred-img");
const phoneInput = $("input[type='tel']");
const selectField = $(".js-filter--section .select-box select");
// Set 'mobile' to false to prevent JS from loading on mobile. Change the media query as desired in DynamicImports.js

export const componentList = [
  {
    element: custom_container,
    className: "CustomContainer",
    mobile: true,
  },
  {
    element: blurredImg,
    className: "LazyLoading",
    mobile: true,
  },
  {
    element: phoneInput,
    className: "PhoneInput",
    mobile: true,
  },
  {
    element: selectField,
    className: "Select2",
    mobile: true,
  },
];

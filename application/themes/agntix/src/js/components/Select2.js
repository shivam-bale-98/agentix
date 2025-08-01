import select2 from "select2";
import "select2/dist/css/select2.css";
import gsap from "gsap";


export default class Select2 {
  constructor() {
    this.window = $(window);
    this.body = $("body");
    this.multiSelectFilters = $(".js-filter--section .select-box.multi-select select");
    this.singleSelectFilters = $(".js-filter--section .select-box.single-select select");
    this.bindEvents();
  }

  bindEvents = () => {
    let trim_length = 0;
    if (this.window.width() >= 991) {
      trim_length = 30;
    } else {
      trim_length = 20;
    }

    this.multiSelectFilters.each((i, el) => {
      let dropbox = $(el).parent();
      console.log($(el), "select array")
      $(el).select2({
        minimumResultsForSearch: -1,
        dropdownParent: $(dropbox).find(".dropdown-result"),
        placeholder: "Select Bussiness Category",
      });
    });

     this.singleSelectFilters.each((i, el) => {
      let dropbox = $(el).parent();

      $(el).select2({
        minimumResultsForSearch: -1,
        dropdownParent: $(dropbox).find(".dropdown-result"),
      });
    });

    $(".filters select").on(
      "select2:open",
      function (e) {
        $(this).parent(".tabs").addClass("select2-open");
        let parent = $(this).parent(".tabs");
        let dropDown = $(parent).find(".dropdown-result");

        let t1 = gsap.timeline();
        let t2 = gsap.timeline({ delay: 0.1 });

        const animationDuration = 0.7; // Duration for opening animation
        const alphaDuration = 0.5; // Duration for fading in

        t1.fromTo(
          dropDown,
          { duration: animationDuration, yPercent: 30, ease: "power3.out" },
          { yPercent: 0 }
        );

        t2.fromTo(
          dropDown,
          { duration: alphaDuration, autoAlpha: 0, ease: "power2.out" },
          { autoAlpha: 1 }
        );
      }
    );

    $(".filters select").on(
      "select2:close",
      function (e) {
        let parent = $(this).parent(".tabs");
        let dropDown = $(parent).find(".dropdown-result");

        let t3 = gsap.timeline();
        let t4 = gsap.timeline({ delay: 0.1 });

        const animationDuration = 0.7; // Duration for closing animation
        const alphaDuration = 0.7; // Duration for fading out

        t4.fromTo(
          dropDown,
          { duration: alphaDuration, autoAlpha: 1, ease: "power2.out" },
          { autoAlpha: 0 }
        );

        t3.fromTo(
          dropDown,
          { duration: animationDuration, yPercent: 0, ease: "power3.out" },
          { yPercent: 30 }
        );

        //trim string
        let select2 = $(this).next(".select2");
        let render = $(select2).find(".select2-selection__rendered");
        let string = $(render).text();
        // if (string.length > trim_length) {
        //   let trimmedString = string.substring(0, trim_length) + "..";
        //   console.log(trimmedString);
        //   $(render).text(trimmedString);
        // }
      }
    );
  };
}

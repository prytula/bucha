/* Please, don't do shit-code  */
Element.prototype.closest || (Element.prototype.closest = function(t) { for (var e = this; e;) { if (e.matches(t)) return e;e = e.parentElement } return null });

Element.prototype.matches || (Element.prototype.matches = Element.prototype.matchesSelector || Element.prototype.webkitMatchesSelector || Element.prototype.mozMatchesSelector || Element.prototype.msMatchesSelector);

Object.assign || Object.defineProperty(Object, "assign", { enumerable: !1, configurable: !0, writable: !0, value: function(e) { "use strict"; if (null == e) throw new TypeError("Cannot convert first argument to object"); for (var t = Object(e), n = 1; n < arguments.length; n++) { var o = arguments[n]; if (null != o) for (var a = Object.keys(Object(o)), c = 0, b = a.length; c < b; c++) { var i = a[c], l = Object.getOwnPropertyDescriptor(o, i); void 0 !== l && l.enumerable && (t[i] = o[i]) } } return t } });

window.NodeList && !NodeList.prototype.forEach && (NodeList.prototype.forEach = Array.prototype.forEach);

function $$(e, o, t) { "function" != typeof o ? o = o || document : (t = o, o = document); var c = o.querySelectorAll(e); return c = Array.prototype.slice.call(o.querySelectorAll(e)), "function" == typeof t && c.forEach(function(e, o, c) { t(e, o, c) }), c }

function addCss(r, s) { var a = function(r) { Object.assign(r.style, s) }; if (Array.isArray(r))
        for (var n = r.length - 1; n >= 0; n--) a(r[n]);
    else a(r) }

function getElementIndex(e) { for (var n = 0; e = e.previousElementSibling;) n++; return n }

function h_el(r) { return !!(Array.isArray(r) && r.length > 0) }

function debugging() { [].forEach.call($$("*"), function(n) { n.style.outline = "1px solid #" + (~~(Math.random() * (1 << 24))).toString(16) }) }

function addEv(e, t, o) {
    e && ("addEventListener"in window ? e.addEventListener(t, o, !1) : "attachEvent"in window && e.attachEvent("on" + t, o))
}
function is_touch_device() {
    return "ontouchstart"in window || navigator.maxTouchPoints
}


function openPopup(selector) {
  const popup = $$(selector)[0]

  return !popup.classList.contains('open') && popup.classList.add('open')
}

function closePopup() {
  const popup = $$('.popup')[0]
  const closeBtn = $$('.popup__close')[0]

  closeBtn.addEventListener('click', () => {
    return popup.classList.contains('open') && popup.classList.remove('open')
  })
}
closePopup()

function galeryInit() {
  if (!$$('.section_2__slider')[0]) {
    return
  }
  const galerySlider = new Swiper('.section_2__slider', {
    speed: 700,
    allowTouchMove: true,
    slidesPerView: 'auto',
    loop: true,
    centeredSlides: true,
    breakpoints: {
      0: {
        mousewheel: {},
      },
      768: {
        slidesPerView: 'auto',
        allowTouchMove: false,
        centeredSlides: false,
        initialSlide: 0,
        loop: false,
      }
    },
    pagination: {
      el: '.slider__pagination',
      clickable: true
    },
    navigation: {
      nextEl: '.slider__next'
    }
  });
}
galeryInit()

sliderInit()
function sliderInit() {
  if (!$$('.main-slider')[0]) {
    return
  }
  const mainSlider = new Swiper('.main-slider', {
    direction: 'vertical',
    speed: 700,
    allowTouchMove: false,
    // mousewheelControl: false,
    mousewheel: {
      invert: false,
    },
    breakpoints: {
      0: {
        mousewheel: {},
      },
      768: {
        speed: 700,
        mousewheelControl: true,
        allowTouchMove: false,
        mousewheel: {
          invert: false,
        },
      }
    },
    pagination: {
      el: '.slider__pagination',
      clickable: true
    },
    navigation: {
      nextEl: '.slider__next'
    }
  });

  mainSlider.on('slideChange', function (e) {
    if (mainSlider.activeIndex % 2 !== 0) {
      if (!$$('.slider__next')[0].classList.contains('white')) {
        $$('.slider__next')[0].classList.add('white')
      }
    } else {
      if ($$('.slider__next')[0].classList.contains('white')) {
        $$('.slider__next')[0].classList.remove('white')
      }
    }
  });
}
sliderInit()

function objectifyForm(form) {
  let formData = form.querySelectorAll("input");

  let returnArray = Array.from(formData).reduce((acc, v) => {
    acc.push(v['value']);
      return acc;
  }, []);

  let str = returnArray.filter(el => el !== '').join('_');

  return str.includes(' ') ? str.replaceAll(' ', '_') : str;
}

function onSuccessRequest(array) {
  const exampleItem = $$('.popup__result_values.example')[0].closest('.popup__result_row');

  $$('.popup__result_values', item => {
    if (!item.classList.contains('exmple')) {
      item.closest('.popup__result_row').remove();
    }
  })

  const userArrMock = array.flat()

  console.log(userArrMock);

  userArrMock.forEach((user) => {
      const itemClone = exampleItem.cloneNode(true);
      itemClone.querySelector('.popup__result_values').classList.remove('example')

      const itemData = {
          name: itemClone.querySelector('.name .value'),
          number: itemClone.querySelector('.index .value'),
          militaryUnit: itemClone.querySelector('.number .value'),
      }
      
      itemData.name.textContent = user.name;
      itemData.number.textContent = user.number;
      itemData.militaryUnit.textContent = user.militaryUnit;
      
      const appendElem = $$('.popup__result_table')[0];
      appendElem.appendChild(itemClone);
  })

  exampleItem.remove()

  $$('.popup__result_values')[0].classList.add('example')
}

function sendRequest() {
  const form = $$('.popup__form')[0]
  const resultTrue = $$('.popup__result--true')[0]
  const resultFalse = $$('.popup__result--false')[0]
  let postData = objectifyForm(form);

  !$$('.preloader')[0].classList.contains('visible') && $$('.preloader')[0].classList.add('visible');
  resultFalse.classList.contains('open') && resultFalse.classList.remove('open');
  resultTrue.classList.contains('open') && resultTrue.classList.remove('open');

  $.ajax({
    type: 'GET',
    headers: {'Content-Type': 'application/json'},
    data: {query: postData},
    url: form.action,
 
    success(data) { 
      
      if ((typeof(data) == 'array' || typeof(data) == 'object') && data.length !== 0) {
        onSuccessRequest(data)
        
        resultFalse.classList.contains('open') && resultFalse.classList.remove('open');
        !resultTrue.classList.contains('open') && resultTrue.classList.add('open');
      } else {
        resultTrue.classList.contains('open') && resultTrue.classList.remove('open');
        !resultFalse.classList.contains('open') && resultFalse.classList.add('open');
      }
      
      $$('.preloader')[0].classList.contains('visible') && $$('.preloader')[0].classList.remove('visible');
    },
    error(){
      console.log('error');
      resultTrue.classList.contains('open') && resultTrue.classList.remove('open');
      !resultFalse.classList.contains('open') && resultFalse.classList.add('open');

      $$('.preloader')[0].classList.contains('visible') && $$('.preloader')[0].classList.remove('visible');
    },
  });
}

function formHandler() {
  const input = $$('.popup__input')[0];
  const button = $$('.popup__button')[0];

  button.addEventListener('click', () => {
    if(input.value !== ' ' && input.value !== '') {
      console.log('search');
      sendRequest()
    }
  })

  input.addEventListener("keydown", function (event) {
    if (event.key === 'Enter') {
      event.preventDefault()
      console.log('search');
      sendRequest()
    }
  });
}
formHandler()

function searchInpuHandler() {
  const searchInput = $$('.search__input')[0];
  if (!searchInput) {
    return
  }
  const button = $$('.search__button')[0];
  
  const formInput = $$('.popup__input')[0];

  button.addEventListener('click', () => {
    if(searchInput.value !== ' ' && searchInput.value !== '') {
      console.log('search');

      formInput.value = searchInput.value;

      sendRequest()
      openPopup('.popup')
    }
  })
}
searchInpuHandler()

function menuClose() {
  const header = $$('.header')[0]
  const button = $$('.header__menu_btn')[0]

  button.addEventListener('click', () => {
    !header.classList.contains('open') ? header.classList.add('open') : header.classList.remove('open');
  })
}
menuClose()

function buttonsUpDown() {
  if ($$('.buttons__flag').length == 0) {
    return
  }
  const header = $$('.buttons')[0]
  const button = $$('.buttons__flag')[0]

  button.addEventListener('click', () => {
    !header.classList.contains('open') ? header.classList.add('open') : header.classList.remove('open');
  })
}
buttonsUpDown()
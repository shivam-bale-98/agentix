
// Helpers
const wrapElements = (elems, wrapType, wrapClass) => {
    elems.forEach(char => {
        const wrapEl = document.createElement(wrapType);
        wrapEl.classList = wrapClass;
        char.parentNode.appendChild(wrapEl);
        wrapEl.appendChild(char);
    });
}

// Slideshow class
if(document.querySelectorAll('.tp-portfolio-slider__main').length){
    class Slider {
        #current = 0;
        constructor(element, reverseDirection = false) {
            this.element = element;
            // Reverse direction
            this.reverseDirection = reverseDirection;
            this.items = [...this.element.querySelectorAll('.tp-portfolio-slider__item')];
            this.itemsInner = this.items.map(item => item.querySelector('.tp-portfolio-slider__item-inner'));
            // Set current
            this.items[this.current].classList.add('current');
            // Total items
            this.itemsTotal = this.items.length;
            gsap.set([this.items, this.itemsInner], {'will-change': 'transform'});
        }
        next() {
            this.navigate(1);
        }
        prev() {
            this.navigate(-1);
        }
        get current() {
            return this.#current;
        }
        set current(value) {
            this.#current = value;
        }
        // direction: 1 || -1 (next || prev)
        navigate(direction) {
            
            if ( this.isAnimating ) return false;
            this.isAnimating = true;
            
            const previous = this.current;
            this.current = direction === 1 ? 
            this.current < this.itemsTotal - 1 ? ++this.current : 0 :
            this.current > 0 ? --this.current : this.itemsTotal - 1
    
            const currentItem = this.items[previous];
            const currentInner = this.itemsInner[previous];
            const upcomingItem = this.items[this.current];
            const upcomingInner = this.itemsInner[this.current];
            
            gsap.timeline({
                defaults: {duration: 1.1, ease: 'power3.inOut'},
                onComplete: () => {
                    this.items[previous].classList.remove('current');
                    this.items[this.current].classList.add('current');
    
                    this.isAnimating = false;
                }
            })
           
            .to(currentItem, {
                xPercent: this.reverseDirection ? direction*100 : -direction*100,
                onComplete: () => gsap.set(currentItem, {opacity: 0})
            })
            .to(currentInner, {
                xPercent: this.reverseDirection ? -direction*30 : direction*30,
                startAt: {
                    rotation: 0
                },
                rotation: -direction*20,
                scaleX: 2.8
            }, 0)
            .to(upcomingItem, {
                startAt: { 
                    opacity: 1, 
                    xPercent: this.reverseDirection ? -direction*80 : direction*80 
                },
                xPercent: 0
            }, 0)
            .to(upcomingInner, {
                startAt: {
                    xPercent: this.reverseDirection ? direction*30 : -direction*30, 
                    scaleX: 2.8, 
                    rotation: direction*20
                },
                xPercent: 0,
                scaleX: 1,
                rotation: 0
            }, 0);
    
        }
    }
// navigation controls
const navigation = {
    'next': document.querySelector('.slider-nav > .slider-nav__item--next'),
    'prev': document.querySelector('.slider-nav > .slider-nav__item--prev'),
    'back': document.querySelector('.slider-nav > .slider-nav__item--back')
};

// Background slider
const sliderBG = new Slider(document.querySelector('.slider--bg'));

// Foreground slider (passing true as the second argument to reverse the animation)
const sliderFG = new Slider(document.querySelector('.slider--fg'), true);

// Titles
const titles = [...document.querySelectorAll('.tp-portfolio-slider-type > .type__item')];

// Set current title
titles[0].classList.add('type__item--current');

// Apply Splitting (https://splitting.js.org/)
titles.forEach(title => title.dataset.splitting = '');
Splitting();

// All chars
const chars = titles.map(title => {
    const titleChars = title.querySelectorAll('.char');
    // Wrap each char in a overflow hidden wrapper
    wrapElements(titleChars, 'span', 'char-wrap');
    return titleChars;
});
gsap.set([titles, chars], {'will-change': 'transform'});

// Navigation
const navigate = action => {
    toggleTitle(action);
    sliderBG[action]();
    sliderFG[action]();
}; 

// Switch titles
const toggleTitle = action => {
    
    if ( sliderBG.isAnimating ) return false;

    const current = sliderBG.current;
    const titleCurrentLetters = chars[current];

    const upcoming = action === 'next' ? 
        current < sliderBG.itemsTotal - 1 ? current+1 : 0 :
        current > 0 ? current-1 : sliderBG.itemsTotal - 1;

    const titleUpcomingLetters = chars[upcoming];

    // change title
    const duration = 1.1;
    // reverse logic for the previous action
    const reverse = action === 'next' ? -1 : 1;
    
    gsap
    .timeline({
        defaults: {duration: duration, ease: 'power4.inOut'},
        onStart: () => {
            titles[upcoming].classList.add('type__item--current');
        },
        onComplete: () => {
            gsap.set(titles[current], {opacity: 0})
            titles[current].classList.remove('type__item--current');
        }
    })
    .set(titles[upcoming], {opacity: 0}, 0)
    .to(titles[current], {
        xPercent: reverse*40
    })
    .to(titleCurrentLetters, {
        xPercent: reverse*103,
    }, 0)
    .addLabel('in', duration*.15, 0)
    .set(titles[upcoming], {opacity: 1}, 'in')
    .to(titles[upcoming], {
        startAt: {
            xPercent: reverse*-40
        },
        xPercent: 0
    }, 'in')
    .to(titleUpcomingLetters, {
        startAt: {
            xPercent: reverse*-103, 
        },
        xPercent: 0
    }, 'in');

}
navigation.next.addEventListener('click', () => navigate('next'));
navigation.prev.addEventListener('click', () => navigate('prev'));

Observer.create({
    target: window,
    type: "wheel,touch,scroll,pointer",
    onUp : () => navigate('next'), 
    onDown : () => navigate('prev'),
    wheelSpeed: -1
});

}

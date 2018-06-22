import Media from './media.json'

export default {
  name: 'HelloWorld',
  data() {
    return {
      msg: 'Vue tutorial!',
      slide: 0,
      sliding: null,
      center: {lat: 12.122527, lng: -86.237792},
      markers: [{
        position: {lat: 12.122527, lng: -86.237792}
      }, ],
      Media
    };
  },
  methods: {
    onSlideStart(slide) {
      this.sliding = true
    },
    onSlideEnd(slide) {
      this.sliding = false
    },
    showModal (modal) {
      this.$root.$emit('bv::show::modal', modal)
    },
    hideModal () {
      this.$root.$emit('bv::hide::modal', modal)
    }
  },
  mounted() {
      let sticky = false; // Declare this variable when is not down.
      const email = 'j.romeroc97@gmail.com';
      const descriptionDiv = $('#description');
      $('.vue-map').css('border-radius', '50%');
      //resize height for browser
      $('.carousel-inner').css('height', '67em');

      function stickNavigation() {
          descriptionDiv.addClass('fixed').removeClass('absolute'); // Fixing div description
          descriptionDiv.removeClass('text-center');
          $('#navigation').slideUp('fast');
          $('#sticky-navigation').slideDown('fast');
      }

      // Esconder navegacion sticky.
      function unStickNavigation() {
          descriptionDiv.removeClass('fixed').addClass('absolute');
          descriptionDiv.addClass('text-center');
          $('#navigation').slideDown('fast');
          $('#sticky-navigation').slideUp('fast');
      }

      // Request con formulario de contacto.
      function sendForm() {
          $.ajax({
              url: $form.attr('action'),
              method: 'POST',
              data: $form.formObject(),
              dataType: 'json',
              success: () => {
                  alert('Everything Ok!');
              }
          });
      }
      // Funcion para determinar cuando el scroll llego hasta abajo.
      function isInBottom() {
          const description = $('#description');
          const descriptionHeight = description.height();
          return $(window).scrollTop() > $(window).height() - (descriptionHeight * 2)
      }

      // Envio de formulario para contacto.
      $('#form-contact').on('submit', (ev) => {
          ev.preventDefault();
          sendForm($(this));
          return false
      });

      /* Define time interval */
      // Funcion para mostrar barra de navegacion sticky.
      $(window).scroll(() => {
          const inBottom = isInBottom();
          // If in bottom and sticky is false
          if (inBottom && !sticky) {
              // Change sticky to true
              sticky = true;
              stickNavigation();
          }
          if (!inBottom && sticky) {
              sticky = false;
              unStickNavigation();
          }
      });

      // Menu button

      $('.icon').on('click', () => {
          const navbar = $('navigation');

          if (navbar.hasClass('responsive')) {
              navbar.removeClass('responsive');
          } else if (!navbar.hasClass('responsive')) {
              navbar.addClass('responsive');
          }
      });

      // Llamar modals

      $('#alquileresSillas').on('click', () => {
          this.$root.$emit('bv::show::modal', 'modal1')
      });

      $('#organizacionEventos').on('click', () => {
          this.$root.$emit('bv::show::modal', 'modal2')
      });

      $('#alquileresMesas').on('click', () => {
         this.$root.$emit('bv::show::modal', 'modal3')
      });

      $('#decoracion').on('click', () => {
         this.$root.$emit('bv::show::modal', 'modal4')
      });

      $('#organizacionCumpleanhos').on('click', () => {
          this.$root.$emit('bv::show::modal', 'modal5')
      });

      $('#organizacionQuinceanhos').on('click', () =>  {
          this.$root.$emit('bv::show::modal', 'modal6')
      });

      $('#buffet').on('click', () => {
          this.$root.$emit('bv::show::modal', 'modal7')
      });

      $('#alquilerUtensilios').on('click', () => {
          this.$root.$emit('bv::show::modal', 'modal8')
      });

      // Elemento css display de los elementos del menu.
      let menuElementsDisplay = $('#navigation .list-inline-item:not(:first-child)').css('display');

      // Funcion para mostrar y ocultar menu en dispositivos moviles en barra de navegacion general.
      $('#button').on('click', () => {
          console.log(menuElementsDisplay);
          switch (menuElementsDisplay) {
              case 'none':
                  $('#navigation .list-inline-item:not(:first-child)').css({
                      display: 'block',
                      'background-color': 'black',
                  });
                  menuElementsDisplay = 'block';
                  break;
              default:
                  $('#navigation div ul li:not(:first-child)').css({
                      display: 'none',
                      'background-color': 'transparent',
                  });
                  menuElementsDisplay = 'none';
          }
      });

      // Funcion para mostrar y ocultar menu en dispositivos moviles en barra de navegacion sticky.
      $('#button-2').on('click', () => {
          console.log(menuElementsDisplay);
          switch (menuElementsDisplay) {
              case 'none':
                  $('#sticky-navigation .list-inline-item:not(:first-child)').css({
                      display: 'block',
                  });
                  menuElementsDisplay = 'block';
                  break;
              default:
                  $('#sticky-navigation .list-inline-item:not(:first-child)').css({
                      display: 'none',
                  });
                  menuElementsDisplay = 'none';
          }
      });

  }

};

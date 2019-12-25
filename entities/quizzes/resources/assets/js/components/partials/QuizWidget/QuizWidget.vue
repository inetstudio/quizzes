<template>
    <div id="add_quiz_widget_modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal inmodal fade" ref="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                    <h1 class="modal-title">Выберите тест</h1>
                </div>
                <div class="modal-body">
                    <div class="ibox-content" v-bind:class="{ 'sk-loading': options.loading }">
                        <div class="sk-spinner sk-spinner-double-bounce">
                            <div class="sk-double-bounce1"></div>
                            <div class="sk-double-bounce2"></div>
                        </div>

                        <base-autocomplete
                            ref="quiz_suggestion"
                            label="Тест"
                            name="quiz_suggestion"
                            v-bind:value="model.additional_info.title"
                            v-bind:attributes="{
                                'data-search': suggestionsUrl,
                                'placeholder': 'Выберите тест',
                                'autocomplete': 'off'
                            }"
                            v-on:select="suggestionSelect"
                        />
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <a href="#" class="btn btn-primary" v-on:click.prevent="save">Сохранить</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    name: 'QuizWidget',
    data() {
      return {
        model: this.getDefaultModel(),
        options: {
          loading: true,
        },
        events: {
          widgetLoaded: function(component) {
            let url = route('back.quizzes-package.quizzes.show', component.model.params.id).toString();

            component.options.loading = true;

            axios.get(url).then(response => {
              $(component.$refs.quiz_suggestion.$refs.autocomplete).val(response.data.title).trigger('change');
              component.options.loading = false;
            });
          },
        },
      };
    },
    computed: {
      suggestionsUrl() {
        return route('back.quizzes-package.quizzes.utility.suggestions').toString();
      },
      modalQuizState() {
        return window.Admin.vue.stores['quizzes-package'].state.mode;
      },
    },
    watch: {
      modalQuizState: function(newMode) {
        if (newMode === 'quiz_created') {
          let quiz = window.Admin.vue.stores['quizzes-package'].state.quiz;

          this.model.params.id = quiz.model.id;

          this.save();
        }
      },
    },
    methods: {
      getDefaultModel() {
        return _.merge(this.getDefaultWidgetModel(), {
          view: 'admin.module.quizzes-package.quizzes::front.partials.content.quiz_widget'
        });
      },
      initComponent() {
        let component = this;

        component.model = _.merge(component.model, this.widget.model);
        component.options.loading = false;
      },
      suggestionSelect(payload) {
        let component = this;

        let data = payload.data;

        component.model.params.id = data.id;
        component.model.additional_info = data;
      },
      save() {
        let component = this;

        if (! _.get(component.model.params, 'id')) {
          $(component.$refs.modal).modal('hide');

          return;
        }

        component.saveWidget(function() {
          $(component.$refs.modal).modal('hide');
        });
      }
    },
    created: function() {
      this.initComponent();
    },
    mounted() {
      let component = this;

      this.$nextTick(function() {
        $(component.$refs.modal).on('hide.bs.modal', function() {
          component.model = component.getDefaultModel();
        });
      });
    },
    mixins: [
      window.Admin.vue.mixins['widget'],
    ],
  };
</script>

<p class="quiz-title quiz-done">Тест пройден</p>
<div class="quiz-result {{($result['type'] == 'full' || $result['type'] == 'short_email') ? 'has-result' : ''}}">

    @if ($result['preview']['id'] && ($result['type'] == 'full' || $result['type'] == 'short_email'))
        <div class="quiz-result_img">
            <img src="{{ $result['preview']['src']['album'] }}">
        </div>
    @endif

    @if ($result['type'] == 'full' || $result['type'] == 'short_email')
        <div class="quiz-result_title">
            {{ $result['title'] }}
        </div>
        <div class="quiz-result_text">
            {!! $result['result'] !!}
        </div>
    @endif

</div>

@if ($result['type'] == 'short_email' || $result['type'] == 'email')
    <p class="results-share">На какой адрес отправить <br>полные результаты теста?</p>
    <div class="subscribe-block">
        <form>
            <input type="hidden" name="quiz_id" value="{{ $result['quiz']['id'] }}">
            <input type="hidden" name="result_id" value="{{ $result['id'] }}">
            <input type="hidden" name="current_url" value="{{ $currentUrl }}">
            <input type="hidden" name="SOURCE" value="quiz">
            <div class="form-row">
                <input type="email" name="email" placeholder="Ваш e-mail">
            </div>
            <div class="form-row">
                <a href="#" class="ajax-submit skin-btn skin-btn-reg"
                   data-href="{{ route('front.quizzes.result.send') }}/" data-custom="quiz"
                   data-gtm-action="subscription-quiz" data-msg="true" data-target="body">Отправить</a>
            </div>
            <div class="form-row-checkbox">
                <div class="quiz-policy-agree">
                    @include('front.elements.checkbox', [
                        'isChecked' => 'checked',
                        'id' => 'policy-agree',
                        'ind' => 'quiz',
                        'text' => 'cоглашаюсь с <a class="link seablue" target="_blank" href="'.route('front.pages.get', ['slug' => 'policy']).'/">Политикой конфиденциальности</a>',
                    ])
                </div>
            </div>
        </form>
    </div>
@endif

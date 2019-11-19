<div class="test-result">
    <p class="results-share">Тест пройден</p>

    @if ($img != '' and ($type == 'full' or $type == 'short_email'))
        <div class="test-result_img">
            <img src="{{ $img }}">
        </div>
    @endif

    @if ($type == 'full' or $type == 'short_email')
        <div class="test-result_title">
            {{ $title }}
        </div>
        <div class="test-result_text">
            {{ $result }}
        </div>
    @endif

    @if ($type == 'short_email' or $type == 'email')
        <p class="test-title">На какой адрес отправить <br>результаты теста?</p>
        <img class="preloader hidden" src="/themes/makeup/images/3_4.png">
        <form class="email_forms test-subscribe-form js-subscribe-form" data-type="emailForm">
            <div class="form-field">
                <input type="hidden" name="quiz_id" value="{{ $quiz->id }}" />
                <input type="hidden" name="result_id" value="{{ $id }}" />
                <input type="email" name="subscribe-email-test-{{ $quiz->id }}" placeholder="ваш e-mail" id="makeup-subscribe-test-{{ $quiz->id }}">
            </div>
            <button class="subscribe-email" type="submit" data-url="{{ route('front.quizes.result.send') }}">ОТПРАВИТЬ</button>

            <div class="form-field checkbox-wrapper hidden-checkbox">
                <input type="checkbox" value="1" checked name="subscribe-terms-test-{{ $quiz->id }}" id="terms-agree-test-{{ $quiz->id }}">
                <label for="terms-agree-test-{{ $quiz->id }}">
                    <span>Я согласен (-на) на получение новостей и рекламной рассылки www.makeup.ru, а также партнеров в соответствии с <a target="_blank" href="{{ url('/rules/newsletter_rules.pdf') }}">Правилами</a>, и разрешаю обработку для этих целей моих персональных данных. </span>
                </label>
            </div>
        </form>
    @endif

    @if ($type == 'full' or $type == 'short_email')
        <p class="results-share">Поделитесь результатом</p>

        <noindex>
            <div class="soc_button sharing_buttom" data-href="share-page" data-switch="1" data-title="{{ urlencode($quiz->title) }}" data-description="{{ urlencode('Мой результат — '.mb_strtolower($title)) }}" data-img="{{ $img }}">
                <div title="Vkontakte" class="soc_vk m-icon-vkontakte"></div>
                <div title="Facebook" class="soc_fb m-icon-facebook"></div>
                <div title="Google+" class="soc_gp m-icon-gplus"></div>
                <div title="Pinterest" class="soc_pc m-icon-pinterest"></div>
            </div>
        </noindex>
    @endif
</div>

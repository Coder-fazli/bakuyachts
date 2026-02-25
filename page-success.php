<?php
/**
 * Template Name: Success Page
 *
 * Success page with header/footer and attractive design
 *
 * @package YACHT RENTAL
 */

// Detect current language from URL
$current_url = $_SERVER['REQUEST_URI'];
$current_lang = 'en';

// Check for AZ language (success-2)
if ( strpos( $current_url, '/az/' ) !== false || strpos( $current_url, 'success-2' ) !== false ) {
    $current_lang = 'az';
// Check for RU language (success-3)
} elseif ( strpos( $current_url, '/ru/' ) !== false || strpos( $current_url, 'success-3' ) !== false ) {
    $current_lang = 'ru';
}

// Multilingual content
$content = array(
    'en' => array(
        'title'    => 'Thank You!',
        'subtitle' => 'Your Message Has Been Sent',
        'message'  => 'We received your message and will get back to you as soon as possible. Our team typically responds within 24 hours.',
        'button'   => 'Back to Home',
        'home'     => home_url( '/' )
    ),
    'az' => array(
        'title'    => 'Təşəkkürlər!',
        'subtitle' => 'Mesajınız Göndərildi',
        'message'  => 'Mesajınızı aldıq və ən qısa zamanda sizinlə əlaqə saxlayacağıq. Komandamız adətən 24 saat ərzində cavab verir.',
        'button'   => 'Ana Səhifəyə',
        'home'     => home_url( '/az/' )
    ),
    'ru' => array(
        'title'    => 'Спасибо!',
        'subtitle' => 'Ваше сообщение отправлено',
        'message'  => 'Мы получили ваше сообщение и свяжемся с вами в ближайшее время. Наша команда обычно отвечает в течение 24 часов.',
        'button'   => 'На Главную',
        'home'     => home_url( '/ru/' )
    )
);

$text = $content[ $current_lang ];

get_header();
?>

<style>
.bky-cf7-section {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
    background: #EEF7FD;
    position: relative;
    overflow: hidden;
}

.bky-cf7-card {
    background: white;
    padding: 40px 40px;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.1);
    text-align: center;
    max-width: 480px;
    width: 100%;
    position: relative;
    z-index: 1;
    animation: bkySlideUp 0.6s ease-out;
}

@keyframes bkySlideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.bky-cf7-icon {
    width: 90px;
    height: 90px;
    margin: 0 auto 20px;
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 30px rgba(56, 239, 125, 0.3);
    animation: bkyPulse 2s ease-in-out infinite;
}

@keyframes bkyPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

.bky-cf7-checkmark {
    width: 40px;
    height: 40px;
    stroke: white;
    stroke-width: 3;
    fill: none;
    animation: bkyDrawCheck 0.8s ease-in-out 0.3s forwards;
    stroke-dasharray: 100;
    stroke-dashoffset: 100;
}

@keyframes bkyDrawCheck {
    to { stroke-dashoffset: 0; }
}

.bky-cf7-title {
    font-size: 36px;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0 0 8px;
    font-family: inherit;
}

.bky-cf7-subtitle {
    font-size: 16px;
    font-weight: 600;
    color: #11998e;
    margin: 0 0 15px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.bky-cf7-msg {
    font-size: 15px;
    line-height: 1.6;
    color: #666;
    margin: 0 0 25px;
}

.bky-cf7-btn {
    display: inline-block;
    padding: 14px 35px;
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    color: white !important;
    font-size: 15px;
    font-weight: 600;
    text-decoration: none !important;
    border-radius: 50px;
    transition: all 0.3s ease;
    box-shadow: 0 5px 20px rgba(56, 239, 125, 0.3);
}

.bky-cf7-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(56, 239, 125, 0.4);
    color: white !important;
}

@media (max-width: 576px) {
    .bky-cf7-section {
        padding: 30px 15px;
    }
    .bky-cf7-card {
        padding: 30px 20px;
    }
    .bky-cf7-title {
        font-size: 28px;
    }
    .bky-cf7-subtitle {
        font-size: 14px;
    }
    .bky-cf7-msg {
        font-size: 14px;
    }
    .bky-cf7-icon {
        width: 70px;
        height: 70px;
    }
    .bky-cf7-checkmark {
        width: 30px;
        height: 30px;
    }
}
</style>

<div class="bky-cf7-section">
    <div class="bky-cf7-card">
        <div class="bky-cf7-icon">
            <svg class="bky-cf7-checkmark" viewBox="0 0 52 52">
                <path d="M14 27 L22 35 L38 17" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>

        <h1 class="bky-cf7-title"><?php echo esc_html( $text['title'] ); ?></h1>
        <p class="bky-cf7-subtitle"><?php echo esc_html( $text['subtitle'] ); ?></p>
        <p class="bky-cf7-msg"><?php echo esc_html( $text['message'] ); ?></p>

        <a href="<?php echo esc_url( $text['home'] ); ?>" class="bky-cf7-btn">
            <?php echo esc_html( $text['button'] ); ?>
        </a>
    </div>
</div>

<?php get_footer(); ?>

@extends('layouts.content')

@section('content')
<section id="about">
    <div class="container">
        <div class="about__image">
            <div class="section-header">
                <span class="gradient-text">FAQ</span>
                <h2>Frequently Asked Questions</h2>
            </div>
            <div class="faq-list">
                @foreach($faqs as $faq) 
                    <div class="faq-item">
                        <button class="faq-question">{{ $faq->question }}</button>
                        <div class="faq-answer" style="color: black;">
                            <p style="color: black;">{{ $faq->answer }}.</p>
                        </div>
                    </div>                                                                                                 
                @endforeach                       
            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br>
        </div>
    </div>
</section>                      

<script>
  document.querySelectorAll('.faq-question').forEach(button => {
    button.addEventListener('click', () => {
      const answer = button.nextElementSibling;
      const isOpen = answer.classList.contains('open');

      document.querySelectorAll('.faq-answer').forEach(a => {
        a.classList.remove('open');
        a.previousElementSibling.classList.remove('active');
      });

      if (!isOpen) {
        answer.classList.add('open');
        button.classList.add('active');
      }
    });
  });
</script>
@endsection
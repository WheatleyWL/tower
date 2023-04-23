    <?php
    /**
     * @var \zedsh\tower\Forms\BaseForm $form
     */
    ?>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2>{{$form->getTitle()}}</h2>
    </div>
    <form action="{{$form->getAction()}}" method="{{$form->getMethod()}}" enctype="{{$form->getEncType()}}">
        @csrf
        {!! $content !!}
        <button type="submit" class="btn btn-primary">Сохранить</button>
        <a href="{{$form->getBack()}}" role="button" class="btn btn-info">Отменить</a>
    </form>

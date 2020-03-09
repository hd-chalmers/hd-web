@extends('layouts.base')


@section('content')
<div class="container bg-light pt-2 pb-1 rounded" style="flex: 1">

    @if($event)
        <div class="alert alert-info mt-1 mb-1">
            <strong>Nästa Event: </strong>
            {{substr($event->date, 0, 16) . ' - ' . $event->title}}
        </div>
    @endif

    <p>
        Dui posuere etiam purus? Congue habitant convallis dolor egestas. Etiam curabitur dolor adipiscing sagittis potenti euismod augue mus vel aptent tellus tempor. Id facilisi mus fermentum tellus. Luctus conubia ullamcorper cras facilisi arcu elementum integer ornare vulputate mattis eros. Dui faucibus aliquam eleifend pharetra facilisi quisque nam taciti malesuada consectetur maecenas. Eget, non semper vel scelerisque accumsan porttitor ligula sagittis placerat morbi. Lectus, quis posuere praesent. Consequat molestie sapien, viverra sapien aliquam ligula sem? Mollis vel eleifend integer sollicitudin senectus sem.
    </p>
    <p>
        Amet blandit condimentum natoque! Primis sociis; dolor magna fusce feugiat. Ad, vulputate ultrices pretium ipsum gravida faucibus pretium placerat turpis nulla. Nostra venenatis viverra felis. Conubia ultrices senectus urna, tortor ultricies senectus? Ultricies sodales luctus in curae; montes pellentesque pellentesque nostra netus eget scelerisque. Pharetra a blandit cursus fames euismod elementum interdum nibh. Tellus venenatis risus ligula fusce pellentesque, felis elit primis. Natoque netus velit tempus velit dis. Nunc volutpat per torquent erat. Ipsum eget venenatis vel curabitur risus duis facilisis tempus.
    </p>
    <p>
        Orci lacus vestibulum fermentum rhoncus inceptos lacus. Feugiat vitae euismod lacinia per mus ante rutrum cras nullam lorem? Habitant lorem odio habitasse venenatis nibh dapibus egestas vestibulum erat. Enim turpis massa suscipit congue hendrerit justo cursus sodales quis phasellus molestie. Eu facilisis platea placerat. Tempus risus nibh pulvinar tellus tortor arcu himenaeos est sed augue nisi adipiscing. Phasellus etiam.
    </p>
    <p>
        Integer non, habitasse habitasse ultrices donec. Id iaculis sociis cum, pharetra cras fames? Libero sociosqu vitae hac metus interdum, suspendisse ultrices commodo. Suspendisse mi, urna sollicitudin class cursus lectus leo a. Eros feugiat lectus diam a sociis metus purus sociis natoque. Mi enim odio potenti pretium penatibus vulputate fringilla, feugiat ultricies nisi gravida. Est neque posuere luctus in. At feugiat consectetur.
    </p>
    <p>
        Mus viverra dictumst sodales rhoncus malesuada vitae amet duis netus, justo torquent praesent. At ridiculus amet vulputate. Conubia congue nisi volutpat eros habitant magna diam class fusce tortor orci mi. Dapibus leo cursus quam neque lacus amet in ut condimentum. Mattis cursus dis pulvinar blandit ligula. Viverra sociosqu tristique aenean faucibus dolor vivamus nec luctus. Tortor nostra ultrices; ligula tincidunt consequat. Venenatis taciti rutrum taciti ornare semper. Curabitur.
    </p>
</div>

@endsection

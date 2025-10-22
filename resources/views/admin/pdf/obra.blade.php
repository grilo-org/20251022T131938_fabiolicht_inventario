<style>
    @font-face {
        font-family: 'Courier';
        font-style: normal;
        font-weight: normal;
        src: url('{{ asset("assets/fonts/Courier.afm") }}') format('truetype');
   }
</style>
<div style='font-family: Courier'>
    <div style='width: 100%; text-align:right;'>1 de 2</div>
    <hr style='border: none; height: 1px; color: #828282; background-color: #828282;'>
    <div style='height: 10%; margin-top: 5px; margin-bottom: 5px;'>
        <table style='width: 100%;'>
            <tr style='width: 100%;'>
                <td style='width: 20%; height: 100px; vertical-align: middle;'>
                    <img src='{{ $logo["base64"] }}' style='width="{{ $logo["width"] }}"; height="{{ $logo["height"] }}"; max-height: 100px; max-width: 200px;'>
                </td>
                {{--}}<td style='width: 80%; text-align: right; float: right;'>
                    <br>
                    <br>
                    <div style='font-weight: bold;'>
                        {{ $instituicaoTitle }}
                    </div>
                    <div>
                        {{ $instituicaoSubTitle ?? "" }}
                    </div>
                </td>{{--}}
            </tr>
        </table>
    </div>
    <hr style='border: none; height: 1px; color: #828282; background-color: #828282;'>
    <div style='padding-top: 10px; padding-bottom: 10px; text-align: center; font-size: 25px; font-weight: 600;'>
            Bens Móveis e Integrados 
    </div>
    <hr style='border: none; height: 1px; color: #828282; background-color: #828282;'>
    <div style='text-align: right; font-size: 15px; font-weight: 600;'>
        CÓDIGO DA FICHA: <span style='font-weight: 500;'>{{ $id }}</span>
    </div>
    <br>
    Título
    <br>
    <div style='font-weight: 600; font-size: 30px; margin-top: 5px;'>{{ $titulo ?? "xxxxx" }}</div>
    <table style='width: 100%;'>
        <tr>
            <td>
                <hr style='border: none; height: 1px; color: #828282; background-color: #828282;'>
                <div style='font-weight: bold;'>Identificação</div>
                <hr style='border: none; height: 1px; color: #828282; background-color: #828282;'>
                <div style='margin-top: 15px;'>Objeto:</div>
                <div style='font-weight: bold; margin-top: 5px;'>{{ $objeto ?? "-" }}</div>
                <div style='margin-top: 15px;'>Categoria:</div>
                <div style='font-weight: bold; margin-top: 5px;'>{{ $categoria ?? "-" }}</div>
                <div style='margin-top: 10px;'>Material:</div>
                <div style='font-weight: bold; margin-top: 5px;'>{{ $material ?? "-" }}</div>
                <div style='margin-top: 10px;'>Técnica:</div>
                <div style='font-weight: bold; margin-top: 5px;'>{{ $tecnica ?? "-" }}</div>
                <div style='margin-top: 10px;'>Século:</div>
                <div style='font-weight: bold; margin-top: 5px;'>{{ $seculo ?? "-" }}</div>
                <div style='margin-top: 10px;'>Ano:</div>
                <div style='font-weight: bold; margin-top: 5px;'>{{ $ano ?? "-" }}</div>
                <div style='margin-top: 10px;'>Autoria:</div>
                <div style='font-weight: bold; margin-top: 5px;'>{{ $autor ?? "-" }}</div>
                <div style='margin-top: 10px;'>Origem / Procedência:</div>
                <div style='font-weight: bold; margin-top: 5px;'>{{ $procedencia ?? "-" }}</div>
                <div style='margin-top: 10px;'>Tombamento:</div>
                <div style='font-weight: bold; margin-top: 5px;'>{{ $tombamento ?? "-" }}</div>
                <div style='margin-top: 10px;'>Estado de Conservação:</div>
                <div style='font-weight: bold; margin-top: 5px;'>{{ $estadoCons ?? "-" }}</div> {{-- Sempre deve estar preenchido --}}
                <div style='margin-top: 10px;'>Condição de Segurança:</div>
                <div style='font-weight: bold; margin-top: 5px;'>{{ $condSeg ?? "-" }}</div> {{-- Sempre deve estar preenchido --}}
            </td>
            <td style='vertical-align: top;'>
                <div style='text-align: center; height: 280px;'>
                    <div style='height:280px; width: 100%;'>
                        <img src='{{ $img1["base64"] }}' style='height="{{ $img1["height"] }}"; width="{{ $img1["width"] }}"; max-height:280px; max-width: 80%;'>
                    </div>
                </div>
                <br>
                <div style='padding-left: 25%; font-size: 14px;'>
                    <span style='font-weight: 400;'>Altura:</span> <span style='font-weight: bold;'>{{ $altura ?? "-" }}</span>
                    <br>
                    <span style='font-weight: 400;'>Largura:</span> <span style='font-weight: bold;'>{{ $larg ?? "-" }}</span>
                    <br>
                    <span style='font-weight: 400;'>Comprimento:</span> <span style='font-weight: bold;'>{{ $comp ?? "-" }}</span>
                    <br>
                    <span style='font-weight: 400;'>Diâmetro:</span> <span style='font-weight: bold;'>{{ $diam ?? "-" }}</span>
                    <br>
                    <span style='font-weight: 400;'>Profundidade:</span> <span style='font-weight: bold;'>{{ $prof ?? "-" }}</span>
                </div>
                <br>
                <div style='text-align: center; height: 280px;'>
                    <div style='height:280px; width: 100%;'>
                        <img src='{{ $img2["base64"] }}' style='height="{{ $img2["height"] }}"; width="{{ $img2["width"] }}"; max-height:280px; max-width: 80%;'>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    {{-- New page --}}
    <div style="page-break-after: always;"></div>
    {{-- New page --}}
    <div style='width: 100%; text-align:right;'>2 de 2</div>
        <table style='height: 40%; width: 100%;'>
            <tr style='width: 100%;'>
                <td style='width: 50%;'>
                    <table style='text-align: left; width: 100%;'>
                        <tr>
                            <td style='text-align: center;'>
                                <div style='height:280px; width: 100%;'>
                                    <img src='{{ $img3["base64"] }}' style='height="{{ $img3["height"] }}"; width="{{ $img3["width"] }}"; max-height:280px; max-width: 80%;'>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style='width: 50%;'>
                    <hr style='border: none; height: 1px; color: #828282; background-color: #828282;'>
                    <div>Localização:</div>
                    <hr style='border: none; height: 1px; color: #828282; background-color: #828282;'>
                    <div style='margin-top: 15px;'>Acervo:</div>
                    <div style='font-weight: bold; margin-top: 5px;'>{{ $acervo ?? "-" }}</div>
                    <div style='margin-top: 10px;'>Município:</div>
                    <div style='font-weight: bold; margin-top: 5px;'>{{ $municipio ?? "-" }}</div>
                    <div style='margin-top: 10px;'>Logradouro:</div>
                    <div style='font-weight: bold; margin-top: 5px;'>{{ $logradouro ?? "-" }}</div>
                    <div style='margin-top: 10px;'>Local no Prédio:</div>
                    <div style='font-weight: bold; margin-top: 5px;'>{{ $locPred ?? "-" }}</div>
                   {{--} <div style='margin-top: 10px;'>Responsável:</div>
                    <div style='font-weight: bold; margin-top: 5px;'>{{ $instituicaoTitle ?? "-" }}</div>{{--}}
                    <br>
                </td>
            </tr>
            <tr>
                <td colspan='2'>
                    <hr style='border: none; height: 1px; color: #828282; background-color: #828282;'>
                    Especificações de segurança:
                    <hr style='border: none; height: 1px; color: #828282; background-color: #828282;'>
                    <div style='font-weight: bold; padding-top: 5px;'>{{ $especEstSeg ?? "-" }}</div>
                    <br>
                    <hr style='border: none; height: 1px; color: #828282; background-color: #828282;'>
                    Especificação do Estado de Conservação:
                    <hr style='border: none; height: 1px; color: #828282; background-color: #828282;'>
                    <div style='font-weight: bold; padding-top: 5px;'>{{ $especEstCons ?? "-" }}</div>
                    <br>
                    <hr style='border: none; height: 1px; color: #828282; background-color: #828282;'>
                    Características Estilísticas, Iconográficas e Ornamentais:
                    <hr style='border: none; height: 1px; color: #828282; background-color: #828282;'>
                    <div style='font-weight: bold; padding-top: 5px;'>{{ $carac ?? "-" }}</div>
                    <br>
                    <br>
                </td>
            </tr>
        </table>
    <div>
    <hr style='border: none; height: 1px; color: #828282; background-color: #828282;'>
    <div style='font-weight: bold; margin-top: 5px;'>OBSERVAÇÕES:</div>
    <hr style='border: none; height: 1px; color: #828282; background-color: #828282;'>
    <div style='height: 60%;'>{{ $obs ?? "-" }}</div>
    <div style='margin-left: auto; margin-right: auto; width: 98%; height: 10%; float: none; margin-top: 10px;'>
        <table style='border: solid; height: 2px; border-collapse: collapse; width: 100%;'>
            <tr>
                <td style='border: solid; height: 2px;'>
                    Inventariado por: {{ $inventarista ?? "-" }}
                    <br>
                    Data: {{ $datainvent ?? "--/--/----" }}
                </td>
                <td style='border: solid; height: 2px;'>
                    Revisado por: {{ $revisor ?? "-" }}
                    <br>
                    @if(!$revisor)
                        Data: {{"--/--/----" }}
                    @else
                        Data: {{ $datarevis ?? "--/--/----" }}
                    @endif
                </td>
            </tr>
        </table>
    </div>
</div>
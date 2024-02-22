
@extends('components.header')
@section('docu', 'DIY')
<x-header />
<x-navbar />
<div class="h-auto ">
    <div class="flex justify-center   md:justify-around flex-col md:flex-row-reverse  py-8 md:py-16 h-auto" style="background-color: #dddddd"">
        <div class="w-100  flex justify-center flex-col-reverse  items-center md:flex-row">
            {{-- Tools --}}
            <div class="flex flex-row md:flex-col   py-2 w-full md:w-auto justify-evenly md:justify-center items-center bg-gray-200 h-auto rounded md:mt-0 mt-10">

                <button id="undo"  class="my-0 md:my-5" disabled>
                    <ion-icon class="h-12 text-4xl hover:text-5xl hover:text-black" name="arrow-undo-circle-outline"></ion-icon> <br>
                    Undo
                </button>

                <button id="redo" class="mb-0 md:mb-5" disabled>
                    <ion-icon class="h-12 text-4xl hover:text-5xl hover:text-black" name="arrow-redo-circle-outline"></ion-icon> <br>
                    Redo
                </button>

                <button id="addText">
                    <ion-icon class="h-12 text-4xl hover:text-5xl hover:text-black" name="text-outline"></ion-icon> <br>
                    Add Text
                </button>
                {{-- Hidden Tools inside the Add Text Buttons  --}}
                <div class="p-2 h-auto py-5 w-auto rounded bg-white shadow-lg absolute  z-40 hidden flex-col md:left-96" id="textDesign">
                    {{-- Textbox --}} 
                        <div class="flex flex-col items-center">
                            <span class="text-xs text-black font-extralight self-start">Custom Text</span>                          
                            <textarea name=""  cols="30" rows="1" id="textToAdd" class="text-center rounded mb-1"></textarea>
                                 <button id="addToCanvas" class="rounded w-full bg-blue-500 text-white text-center px-2 py-2 m-0 hover:bg-blue-300">
                                     Add
                                 </button>
                        </div>
                        {{-- Fonts Color --}}
                        <div class="flex flex-col  items-center my-2">
                            <span class="text-xs text-black font-extralight my-1 self-start">Font Color</span>
                            <div class="w-auto self-center h-8">
                                <button class="bg-black  p-2  cursor-pointer   hover:p-4" onclick="changeFontColor('black')"></button>
                                <button class="bg-white  p-2  cursor-pointer hover:p-4" onclick="changeFontColor('white')"></button>
                                <button class="bg-gray-500  p-2  cursor-pointer hover:p-4" onclick="changeFontColor('gray')"></button>
                                <button class="bg-red-900  p-2  cursor-pointer hover:p-4" onclick="changeFontColor('red')"></button>
                                <button class="bg-blue-900  p-2  cursor-pointer hover:p-4" onclick="changeFontColor('blue')"></button>
                                <button class="bg-yellow-200  p-2  cursor-pointer hover:p-4" onclick="changeFontColor('yellow')"></button>
                                <button class="bg-green-500  p-2  cursor-pointer hover:p-4" onclick="changeFontColor('green')"></button>
                                <button class="bg-orange-500  p-2  cursor-pointer hover:p-4" onclick="changeFontColor('orange')"></button>
                                <button class="bg-violet-400  p-2  cursor-pointer hover:p-4" onclick="changeFontColor('violet')"></button>
                                <button class="bg-purple-700  p-2  cursor-pointer hover:p-4" onclick="changeFontColor('purple')"></button>
                                <button class="bg-pink-500  p-2  cursor-pointer hover:p-4" onclick="changeFontColor('pink')"></button>
                                <button class="bg-rose-950  p-2  cursor-pointer hover:p-4" onclick="changeFontColor('rose')"></button>
                                <button class="bg-purple-700  p-2  cursor-pointer hover:p-4" onclick="changeFontColor('purple')"></button>
                            </div>
                        </div>
                         {{-- Font Style --}}
                        <div class="mt-1 flex flex-col ">
                            <span class="text-xs text-black font-extralight my-1 self-start">Font Style</span>
                            <div class="flex justify-evenly flex-row">                       
                                    <button class="font-extrabold text-xl tracking-wider hover:text-lg" onclick="fontBold()">
                                         BOLD
                                    </button>      
                                    <button class="italic text-xl tracking-wider hover:text-lg" onclick="fontItalic()">
                                         ITALIC
                                     </button>      
                            </div>
                        </div>
                        {{-- Font Family --}}
                        <div class="mt-1 flex flex-col">
                            <span class="text-xs text-black font-extralight my-1 self-start">Font Family</span>
                            <select onchange="changeFontFamily(this.value)" class="cursor-pointer">
                                <option value="Arial">Arial</option>
                                <option value="Times New Roman">Times New Roman</option>
                                <option value="Helvetica">Helvetica</option>
                                <option value="Georgia">Georgia</option>
                                <option value="Verdana">Verdana</option>
                                <option value="Courier New">Courier New</option>
                                <option value="Trebuchet MS">Trebuchet MS</option>
                                <option value="Impact">Impact</option>
                                <option value="Comic Sans MS">Comic Sans MS</option>
                                
                            </select>
                        </div>
                        <div class="md:hidden block my-2" id="closeTools">
                            <button class="w-full text-center px-1 bg-red-500 text-white rounded">
                                Close
                            </button>
                        </div>
                    </div>
                <button class="relative  p-0 md:p-4 rounded m-0 md:m-2 z-20 ">
                        <ion-icon name="images-outline" class="h-12 text-4xl hover:text-5xl hover:text-black"></ion-icon> <br>Import
                        <input type="file" class="absolute md:left-10 left-0  top-4 z-0 w-8  h-8 opacity-0" id="imageUpload" onchange="uploadImage()">
                </button>
            </div>
        <div>      
                <div class="flex flex-col justify-between relative">
                    {{-- The canvas --}}
                    <canvas id="fabricCanvas" width="400" height="400" style="border:1px solid #ccc;" >
                    </canvas>
                    <div class="absolute hidden" id="canvas2">
                        <canvas id="fabricCanvas2" width="400" height="400" style="border: 1px solid #ccc;">

                        </canvas>
                    </div>
                    <div class="absolute top-0 right-0 flex flex-col">
                        {{-- Front view of the T-Shirt --}}
                        <div class="w-10 border h-18 bg-gray-400 me-1 p-1">
                                <img src="{{ asset('images/whiteColor.png') }}" alt="whiteColor" height="10px" class="cursor-pointer "  onclick="tshirtFront()">
                                <span class="font-xs text-center font-bold" style="font-size: 13px">Front</span>
                        </div>
                        {{-- Back view of the T-Shirt --}}
                        <div class="w-10 border h-18 bg-gray-400 me-1 p-1">
                            <img src="{{ asset('images/back.png') }}" alt="whiteColor" width="auto" class="cursor-pointer"  onclick="tshirtBack()">
                            <span class="font-xs text-center font-bold" style="font-size: 13px">Back</span>
                        </div>
                    </div>
                </div>
                {{--  T-Shirt Colors (Front) --}}
              <div class="block" id="frontView">            
                <div class="flex flex-row justify-center items-center" id="frontView">
                    <div class="w-10 border h-10 bg-gray-400 me-1 p-1 hover:bg-gray-200">
                        <button data-image="{{ asset('images/whiteColor.png') }}" class="colorButton"><img src="{{ asset('images/whiteColor.png') }}" alt=""></button>
                    </div>
                    <div class="w-10 border h-10 bg-gray-400 me-1 p-1 hover:bg-gray-200">
                        <button data-image="{{ asset('images/gray.png') }}" class="colorButton"><img src="{{ asset('images/gray.png') }}" alt=""></button>
                    </div>
                    <div class="w-10 border h-10 bg-gray-400 me-1 p-1 hover:bg-gray-200">
                        <button data-image="{{ asset('images/blue.png') }}" class="colorButton"><img src="{{ asset('images/blue.png') }}" alt=""></button>
                    </div>
                    <div class="w-10 border h-10 bg-gray-400 me-1 p-1 hover:bg-gray-200">
                        <button data-image="{{ asset('images/purple.png') }}" class="colorButton"><img src="{{ asset('images/purple.png') }}" alt=""></button>
                    </div>
                    <div class="w-10 border h-10 bg-gray-400 me-1 p-1 hover:bg-gray-200">
                        <button data-image="{{ asset('images/black.png') }}" class="colorButton"><img src="{{ asset('images/black.png') }}" alt=""></button>
                    </div>
                    <div class="w-10 border h-10 bg-gray-400 me-1 p-1 hover:bg-gray-200">
                        <button data-image="{{ asset('images/red.png') }}" class="colorButton"><img src="{{ asset('images/red.png') }}" alt=""></button>
                    </div>
                    <div class="w-10 border h-10 bg-gray-400 me-1 p-1 hover:bg-gray-200">
                        <button data-image="{{ asset('images/green.png') }}" class="colorButton"><img src="{{ asset('images/green.png') }}" alt=""></button>
                    </div>
                    <div class="w-10 border h-10 bg-gray-400 me-1 p-1 hover:bg-gray-200">
                        <button data-image="{{ asset('images/maroon.png') }}" class="colorButton"><img src="{{ asset('images/maroon.png') }}" alt=""></button>
                    </div>
                    <div class="w-10 border h-10 bg-gray-400 me-1 p-1 hover:bg-gray-200">
                        <button data-image="{{ asset('images/yellow.png') }}" class="colorButton"><img src="{{ asset('images/yellow.png') }}" alt=""></button>
                    </div>                                  
                </div>
              </div>
              {{-- T-Shirt Colors (Back) --}}
              <div class="hidden" id="backView">
                <div class="flex flex-row justify-center items-center">
                    <div class="w-10 border h-10 bg-gray-400 me-1 p-1 hover:bg-gray-200">
                        <button data-image="{{ asset('images/whiteColor.png') }}" class="colorButton"><img src="{{ asset('images/whiteColor.png') }}" alt=""></button>
                    </div>
                    <div class="w-10 border h-10 bg-gray-400 me-1 p-1 hover:bg-gray-200">
                        <button data-image="{{ asset('images/gray.png') }}" class="colorButton"><img src="{{ asset('images/whiteColor.png') }}" alt=""></button>
                    </div>
                    <div class="w-10 border h-10 bg-gray-400 me-1 p-1 hover:bg-gray-200">
                        <button data-image="{{ asset('images/blue.png') }}" class="colorButton"><img src="{{ asset('images/whiteColor.png') }}" alt=""></button>
                    </div>
                    <div class="w-10 border h-10 bg-gray-400 me-1 p-1 hover:bg-gray-200">
                        <button data-image="{{ asset('images/purple.png') }}" class="colorButton"><img src="{{ asset('images/whiteColor.png') }}" alt=""></button>
                    </div>
                    <div class="w-10 border h-10 bg-gray-400 me-1 p-1 hover:bg-gray-200">
                        <button data-image="{{ asset('images/black.png') }}" class="colorButton"><img src="{{ asset('images/whiteColor.png') }}" alt=""></button>
                    </div>
                    <div class="w-10 border h-10 bg-gray-400 me-1 p-1 hover:bg-gray-200">
                        <button data-image="{{ asset('images/red.png') }}" class="colorButton"><img src="{{ asset('images/whiteColor.png') }}" alt=""></button>
                    </div>
                    <div class="w-10 border h-10 bg-gray-400 me-1 p-1 hover:bg-gray-200">
                        <button data-image="{{ asset('images/green.png') }}" class="colorButton"><img src="{{ asset('images/whiteColor.png') }}" alt=""></button>
                    </div>
                    <div class="w-10 border h-10 bg-gray-400 me-1 p-1 hover:bg-gray-200">
                        <button data-image="{{ asset('images/maroon.png') }}" class="colorButton"><img src="{{ asset('images/whiteColor.png') }}" alt=""></button>
                    </div>
                    <div class="w-10 border h-10 bg-gray-400 me-1 p-1 hover:bg-gray-200">
                        <button data-image="{{ asset('images/yellow.png') }}" class="colorButton"><img src="{{ asset('images/whiteColor.png') }}" alt=""></button>
                    </div>                                  
                </div>
               
              </div>
               
            </div>
        </div>  
        {{-- Tables  --}}
        <div class="flex justify-center items-center flex-col">
                <div>
                    <table class="w-auto text-center">
                        <tr class="w-full">
                            <th colspan="10">Adult Size</th>
                        </tr>
                       <tr class="bg-gray-400 rounded">
                            <th class="w-16">Sizes</th>
                            <th class="w-12">S</th>
                            <th class="w-12">M</th>
                            <th class="w-12">L</th>
                            <th class="w-12">XL</th>
                            <th class="w-12">2XL</th>
                       </tr>
                        <tr class="border-b border-gray-200 bg-white text-sm font-extralight">
                            <td>Width</td>
                            <td>19</td>
                            <td>20</td>
                            <td>21</td>
                            <td>22</td>
                            <td>23</td>
                        </tr>
                        <tr class="border-b border-gray-200 bg-white text-sm font-extralight">
                            <td>Length</td>
                            <td>26</td>
                            <td>27</td>
                            <td>28</td>
                            <td>29</td>
                            <td>29</td>
                        </tr>
                    </table>
                </div>
                <div class="my-2">
                    <img src="{{ asset('images/W_L.png') }}" alt="">
                </div>
                <div>
                    <table class="w-auto text-center">
                        <tr class="w-full">
                            <th colspan="10">Kid Size</th>
                        </tr>
                       <tr class="bg-gray-400 rounded">
                            <th class="w-16">Sizes</th>
                            <th class="w-12">S</th>
                            <th class="w-12">M</th>
                            <th class="w-12">L</th>
                            <th class="w-12">XL</th>
                            <th class="w-12">2XL</th>
                       </tr>
                        <tr class="border-b border-gray-200 bg-white text-sm font-extralight">
                            <td>Width</td>
                            <td>19</td>
                            <td>20</td>
                            <td>21</td>
                            <td>22</td>
                            <td>23</td>
                        </tr>
                        <tr class="border-b border-gray-200 bg-white text-sm font-extralight">
                            <td>Length</td>
                            <td>26</td>
                            <td>27</td>
                            <td>28</td>
                            <td>29</td>
                            <td>29</td>
                        </tr>
                    </table>
                </div>
                <div>

                </div>
        </div>
    </div>
    {{-- Buttons for Guide, Pricing and Download --}} 
     <div class="flex flex-row justify-between transition-all mx-0 md:mx-20 items-center">
        <div>
            <a href="#guide">
            <button class="py-2 px-1 text-white bg-red-800 text-md font-light rounded ms-2 my-2 w-32 md:w-48 hover:bg-red-400">
                
                Guide</button>
            </a>
        </div>
        <div class="flex flex-row">
            <div class="hover:text-white">
                 <button class="p-2 my-2 text-md font-light rounded  flex justify-evenly items-center border hover:bg-blue-700 border-blue-500 w-16 md:w-36 me-5 hover:border-blue-600">
                    <ion-icon name="cash-outline" class="text-2xl"></ion-icon> 
                    <div class="hidden md:block">
                        Pricing
                    </div>
                </button>
            </div>
            <div>          
                    <button id="downloadCanvas" class="p-2 my-2 text-md font-bold rounded  hover:bg-blue-500 text-white flex justify-evenly  items-center w-32 md:w-36 bg-blue-700">
                        <ion-icon name="cloud-download-outline" class="text-2xl text-white"></ion-icon>
                        <div class="hidden md:block text-white">
                            Download
                        </div>
                    </button>
            </div>
        </div>
    </div>
    {{-- Guide on mock up t shirt  --}}
       <section id="guide">
            <h1 class="text-center text-4xl italic mt-5">Guide</h1>
            <div class="flex justify-evenly flex-row items-center">
                <div>
                    <img src="{{ asset('images/logo.png') }}" alt="" width="250px">
                </div>
                <div class="w-4/12">
                    <p class="indent-10">
                     Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus vitae voluptas minus quia illo repellat obcaecati soluta earum alias provident.
                    </p>
                </div>
            </div>    
        </section>   
</div>

{{-- Javascript --}}
  
    <x-footer />
    @include('partial\_Tools');
    <x-scripts />

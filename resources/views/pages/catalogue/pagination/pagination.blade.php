 <div class="col mt-5">
     {{-- Texte d'information --}}
     <div class="mb-2">
         <p class="text-muted small">
             Affichage de <span class="fw-bold">{{ $catalogue->firstItem() }}</span>
             à <span class="fw-bold">{{ $catalogue->lastItem() }}</span>
             sur <span class="fw-bold">{{ $catalogue->total() }}</span> résultats
         </p>
     </div>

     {{-- Pagination --}}
     <div class="d-flex justify-content-start">
         <nav aria-label="Page navigation example">
             <ul class="pagination">
                 {{-- Bouton Previous --}}
                 @if ($catalogue->onFirstPage())
                     <li class="page-item disabled">
                         <span class="page-link">Précédant</span>
                     </li>
                 @else
                     <li class="page-item">
                         <a class="page-link"
                             href="{{ $catalogue->appends(request()->query())->previousPageUrl() }}">Précédant</a>
                     </li>
                 @endif

                 {{-- Numéros de pages --}}
                 @foreach ($catalogue->getUrlRange(1, $catalogue->lastPage()) as $page => $url)
                     @if ($page == $catalogue->currentPage())
                         <li class="page-item active">
                             <span class="page-link">{{ $page }}</span>
                         </li>
                     @else
                         <li class="page-item">
                             <a class="page-link"
                                 href="{{ $catalogue->appends(request()->query())->url($page) }}">{{ $page }}</a>
                         </li>
                     @endif
                 @endforeach

                 {{-- Bouton Next --}}
                 @if ($catalogue->hasMorePages())
                     <li class="page-item">
                         <a class="page-link"
                             href="{{ $catalogue->appends(request()->query())->nextPageUrl() }}">Suivant</a>
                     </li>
                 @else
                     <li class="page-item disabled">
                         <span class="page-link">Suivant</span>
                     </li>
                 @endif
             </ul>
         </nav>
     </div>
 </div>

  <!-- URL principale -->
  @if (!empty($app->url_app))
      <div class="mb-3">
          <label class="form-label text-muted fw-semibold small mb-1">URL D'ACCÈS</label>
          <div class="input-group input-group-sm">
              <span class="input-group-text bg-light border-end-0">
                  <i class="bi bi-globe text-primary"></i>
              </span>
              <input type="text" class="form-control border-start-0 bg-light" value="{{ $app->url_app }}" readonly>
              <a href="{{ $app->url_app }}" target="_blank" class="btn btn-outline-primary btn-sm">
                  <i class="bi bi-box-arrow-up-right"></i>
              </a>
          </div>
      </div>
  @endif

  <!-- Environnements -->
  <div class="mb-3">
      <label class="form-label text-muted fw-semibold small mb-2">ENVIRONNEMENTS</label>
      <div class="row g-2">
          @if (!empty($app->adr_serv_prod))
              <div class="col-12">
                  <div class="bg-success bg-opacity-10 border border-success border-opacity-25 rounded p-2">
                      <div class="d-flex align-items-center justify-content-between">
                          <div class="d-flex align-items-center">
                              <span class="badge bg-success me-2">PROD</span>
                              <small class="text-muted">{{ $app->adr_serv_prod }}</small>
                          </div>
                          <i class="bi bi-check-circle text-success"></i>
                      </div>
                  </div>
              </div>
          @endif

          @if (!empty($app->adr_serv_test))
              <div class="col-12">
                  <div class="bg-warning bg-opacity-10 border border-warning border-opacity-25 rounded p-2">
                      <div class="d-flex align-items-center justify-content-between">
                          <div class="d-flex align-items-center">
                              <span class="badge bg-warning text-dark me-2">TEST</span>
                              <small class="text-muted">{{ $app->adr_serv_test }}</small>
                          </div>
                          <i class="bi bi-exclamation-triangle text-warning"></i>
                      </div>
                  </div>
              </div>
          @endif

          @if (!empty($app->adr_serv_dev))
              <div class="col-12">
                  <div class="bg-info bg-opacity-10 border border-info border-opacity-25 rounded p-2">
                      <div class="d-flex align-items-center justify-content-between">
                          <div class="d-flex align-items-center">
                              <span class="badge bg-info text-dark me-2">DEV</span>
                              <small class="text-muted">{{ $app->adr_serv_dev }}</small>
                          </div>
                          <i class="bi bi-code-slash text-info"></i>
                      </div>
                  </div>
              </div>
          @endif
      </div>
  </div>

<div class="modal fade" id="demandeServModal" tabindex="-1" aria-labelledby="demandeServModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="demandeServModalLabel">
                    <i class="bi bi-server text-success me-2"></i> Faire une demande de serveur
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>

            <form action="{{ route('faire.demande') }}" method="POST" id="demandeServForm">
                @csrf
                <div class="modal-body">

                    <div id="demandeServErrors" class="alert alert-danger d-none" role="alert"></div>

                    <div class="row g-3 mb-4 p-3 border rounded mt-2">

                        <div class="col-12">
                            <label for="description" class="form-label">Description du projet</label>
                            <textarea name="description" id="description" class="form-control" rows="3"
                                placeholder="Décrivez brièvement le projet"></textarea>
                        </div>

                        <div class="col-12">
                            <label for="environnement" class="form-label">Environnement <span
                                    class="text-danger">*</span></label>
                            <select name="environnement" id="environnement" class="form-select" required>
                                <option value="" disabled selected>Choisir...</option>
                                <option value="DEV">DEV</option>
                                <option value="TEST">TEST</option>
                                <option value="PROD">PROD</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="type_serveur" class="form-label">Type de serveur</label>
                            <select name="type_serveur" id="type_serveur" class="form-select">
                                <option value="virtuel" selected>Virtuel</option>
                                <option value="physique">Physique</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="systeme_exploitation" class="form-label">Système d'exploitation <span
                                    class="text-danger">*</span></label>
                            <select name="systeme_exploitation" id="systeme_exploitation" class="form-select" required>
                                <option value="" disabled selected>Choisir...</option>
                                <option value="Windows">Windows</option>
                                <option value="Linux">Linux</option>
                                <option value="Mac">Mac</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="version_os" class="form-label">Version OS <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="version_os" id="version_os" class="form-control" required
                                placeholder="Ex: 22.04, 2019">
                        </div>

                        <div class="col-12">
                            <label for="architecture" class="form-label">Architecture</label>
                            <select name="architecture" id="architecture" class="form-select">
                                <option value="64-bit" selected>64-bit</option>
                                <option value="32-bit">32-bit</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="ram_go" class="form-label">RAM (Go) <span class="text-danger">*</span></label>
                            <input type="number" name="ram_go" id="ram_go" class="form-control" min="1"
                                required placeholder="Ex: 8">
                        </div>

                        <div class="col-12">
                            <label for="stockage_go" class="form-label">Stockage (Go) <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="stockage_go" id="stockage_go" class="form-control"
                                min="1" required placeholder="Ex: 100">
                        </div>

                        <div class="col-12">
                            <label for="type_stockage" class="form-label">Type de stockage</label>
                            <select name="type_stockage" id="type_stockage" class="form-select">
                                <option value="SSD" selected>SSD</option>
                                <option value="HDD">HDD</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Soumettre la demande</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                </div>

            </form>
        </div>
    </div>
</div>

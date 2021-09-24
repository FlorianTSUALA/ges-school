<?php

use Core\Routing\URL;
use App\Helpers\Helpers;

?>


<div class="modal animated fadeInDownBig text-left" id="modal_modele_message_create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel41" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #f5a663;">
                <h4 class="modal-title" id="create_title"><?= "Creation d'un modele de message" ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class="needs-validation" id="create-form" method="POST" action="" novalidate>
                <div class="modal-body">
                    <div class="card-body">
                        <main>
                            <div class="message">
                                <div class="centered">
                                    <div class="form-group row">
                                        <label for="nom" class="col-1 col-form-label">nom <?= Helpers::required_input(); ?>:</label>
                                        <div class="col-11">
                                            <input placeholder="Nom du modele de message" type="text" class="form-control required" id="nom" name="nom" autofocus required="required" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="centered">
                                <div class="row row-editor">
                                    <div class="editor-container">
                                        <div class="editor">
                                            <h2>Bilingual Personality Disorder</h2>
                                            <figure class="image image-style-side"><img src="https://c.cksource.com/a/1/img/docs/sample-image-bilingual-personality-disorder.jpg">
                                                <figcaption>One language, one person.</figcaption>
                                            </figure>
                                            <p>
                                                This may be the first time you hear about this made-up disorder but
                                                it actually isn’t so far from the truth. Even the studies that were
                                                conducted almost half a century show that
                                                <strong>the language you speak has more effects on you than you
                                                    realise</strong>.
                                            </p>
                                            <p>
                                                One of the very first experiments conducted on this topic dates back to
                                                1964.
                                                <a href="https://www.researchgate.net/publication/9440038_Language_and_TAT_content_in_bilinguals">In
                                                    the experiment</a>
                                                designed by linguist Ervin-Tripp who is an authority expert in
                                                psycholinguistic and sociolinguistic studies,
                                                adults who are bilingual in English in French were showed series of pictures
                                                and were asked to create 3-minute stories.
                                                In the end participants emphasized drastically different dynamics for
                                                stories in English and French.
                                            </p>
                                            <p>
                                                Another ground-breaking experiment which included bilingual Japanese women
                                                married to American men in San Francisco were
                                                asked to complete sentences. The goal of the experiment was to investigate
                                                whether or not human feelings and thoughts
                                                are expressed differently in <strong>different language mindsets</strong>.
                                                <Here>is a sample from the the experiment:</Here>
                                            </p>
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>English</th>
                                                        <th>Japanese</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Real friends should</td>
                                                        <td>Be very frank</td>
                                                        <td>Help each other</td>
                                                    </tr>
                                                    <tr>
                                                        <td>I will probably become</td>
                                                        <td>A teacher</td>
                                                        <td>A housewife</td>
                                                    </tr>
                                                    <tr>
                                                        <td>When there is a conflict with family</td>
                                                        <td>I do what I want <span class="mention" data-mention="@Marshall">@Marshall</span></td>
                                                        <td>It's a time of great unhappiness</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <p>
                                                More recent <a href="https://books.google.pl/books?id=1LMhWGHGkRUC">studies</a> show,
                                                the language a person speaks affects
                                                their cognition, behaviour, emotions and hence <strong>their
                                                    personality</strong>.
                                                This shouldn’t come as a surprise
                                                <a href="https://en.wikipedia.org/wiki/Lateralization_of_brain_function">since
                                                    we already know</a> that different regions
                                                of the brain become more active depending on the person’s activity at hand.
                                                Since structure, information and especially
                                                <strong>the culture</strong> of languages varies substantially and the
                                                language a person speaks is an essential element of daily life.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </main>
                    </div>
                </div>
                <div id="upt-loading" class="spinner-grow text-warning" role="status"> <span class="sr-only">Loading...</span></div>


                <div class="modal-footer" id="button-form-create">
                    <input type="reset" class="btn btn-danger" data-dismiss="modal" value="Annuler">
                    <input type="submit" id="button-create" class="btn btn-warning btn-darken-2" value="Sauvegarder">
                </div>
                <input type="hidden" name="code" id="upd-code" />
            </form>
        </div>
    </div>
</div>
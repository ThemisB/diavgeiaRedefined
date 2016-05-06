<?php
$READ_DOMAIN_INFO = true;
$SEARCH_PAGE = true;

require_once '../config.php';
?>
<!DOCTYPE html>
<html>

  <head>
    <link href="<?php echo $css_url; ?>" rel="stylesheet" type="text/css" />
    <title>Πληροφορίες αναφορικά με τα κριτήρια αναζήτησης</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style type="text/css">
      .captionSpacing{
        height:10px;
      }
      .topicSpacing{
        height:20px;
      }
    </style>
  </head>
  <body>

    <div id="notice">
      <h3>Πληροφορίες αναφορικά με τα κριτήρια αναζήτησης</h3>
    </div>
    <br />
    <div>
      <ul class="bullets_on">
        <li><a href="#ada">ΑΔΑ (Aριθμός Διαδικτυακής Ανάρτησης)</a></li>
        <?php if (all_orgs()): ?>
          <li><a href="#foreas">Φορέας</a></li>
        <?php endif ?>
        <li><a href="#protocol">Αρ. Πρωτοκόλλου</a></li>
        <li><a href="#submissionDate">Ημερομηνία Aνάρτησης</a></li>
        <li><a href="#topic"> Θέμα</a></li>
        <li><a href="#topicUnit"> Θεματική ενότητα</a></li>
        <li><a href="#decisionType"> Είδος απόφασης</a></li>
        <li><a href="#signer"> Τελικός Υπογράφων</a></li>
      </ul>
    </div>
    <br/>
    <br/>
    <table style="border:0px">
      <tbody>
        <tr>
          <td>
            <strong><a id="ada">ΑΔΑ (Aριθμός Διαδικτυακής Ανάρτησης)</a></strong>

          </td>

        </tr>
        <tr><td class="captionSpacing"></td></tr>
        <tr>
          <td>
            Στο πεδίο αυτό μπορείτε να πληκτρολογήσετε τον ΑΔΑ για τον οποίο επιθυμείτε να πραγματοποιήσετε αναζήτηση.
          </td>
        </tr>
        <?php if (all_orgs()): ?>
          <tr><td class="topicSpacing"></td></tr>
          <tr>
            <td>
              <strong><a id="foreas"> Φορέας</a></strong>
            </td>
          </tr>
          <tr><td class="captionSpacing"></td></tr>
          <tr>
            <td>
              Αφότου αρχίσετε να πληκτρολογείτε το όνομα του φορέα για τον οποίο επιθυμείτε να πραγματοποιήσετε αναζήτηση, εμφανίζεται βοήθεια. Για την σωστή λειτουργία της βοήθειας θα χρειαστεί να πληκτρολογήσετε τουλάχιστον 4 χαρακτήρες και μόνο στα ελληνικά. Με την επιλογή Φορέα ενεργοποιείται και η δυνατότητα επιλογής συγκεκριμένου Υπογράφοντα.
            </td>
          </tr>
        <?php endif ?>
        <tr><td class="topicSpacing"></td></tr>
        <tr>
          <td><strong><a id="protocol">Αρ. Πρωτοκόλλου</a></strong></td>
        </tr>
        <tr><td class="captionSpacing"></td></tr>
        <tr>
          <td>
            Στο πεδίο αυτό μπορείτε να πληκτρολογήσετε τον αριθμό πρωτοκόλου για τον οποίο επιθυμείτε να πραγματοποιήσετε αναζήτηση.
          </td>

        </tr>
        <tr><td class="topicSpacing"></td></tr>
        <tr>
          <td><strong><a id="submissionDate">Ημερομηνία Aνάρτησης</a></strong></td>
        </tr
        <tr><td class="captionSpacing"></td></tr>
        <tr>
          <td>Εάν το κριτήριο αναζήτησης 'Ημερομηνία Ανάρτησης' είναι επιλεγμένο, τότε το μέγιστο επιτρεπόμενο εύρος ημερομηνιών ανάρτησης είναι 30 ημερολογιακές ημέρες.</td>
        </tr>
        <tr><td class="topicSpacing"></td></tr>
        <tr>
          <td><strong><a id="topic">Θέμα</a></strong></td>
        </tr>
        <tr><td class="captionSpacing"></td></tr>
        <tr>
          <td>Για την καλύτερη αποδοτικότητα της αναζήτησης παρακαλώ συμπληρώστε το πεδίο 'Θέμα' με τουλάχιστον 5 χαρακτήρες.</td>
        </tr>
        <tr><td class="topicSpacing"></td></tr>
        <tr>
          <td><strong><a id="topicUnit"> Θεματική ενότητα</a></strong></td>
        </tr>
        <tr><td class="captionSpacing"></td></tr>
        <tr>
          <td>Στη σχετική λίστα εμφανίζονται μόνο οι Θεματικές Ενότητες για τις οποίες υπάρχουν καταχωρημένες αποφάσεις.</td>
        </tr>
        <tr><td class="topicSpacing"></td></tr>
        <tr>
          <td><strong><a id="decisionType">Είδος απόφασης</a></strong></td>
        </tr>
        <tr><td class="captionSpacing"></td></tr>
        <tr>
          <td>Στη σχετική λίστα εμφανίζονται μόνο τα Είδη αποφάσεων για τα οποία έχουν πραγματοποιηθεί αναρτήσεις αποφάσεων.</td>
        </tr>
        <tr><td class="topicSpacing"></td></tr>
        <tr>
          <td>
            <strong><a id="signer">Τελικός Υπογράφων</a></strong>
          </td>
        </tr>
        <tr><td class="captionSpacing"></td></tr>
        <tr>
         
          <?php if (all_orgs()){ ?>
          <td>
            Στη σχετική λίστα εμφανίζονται μόνο οι Τελικοί Υπογράφοντες οι οποίοι έχουν πραγματοποιήσει αναρτήσεις αποφάσεων.Το πεδίο ενεργοποιείται μόνο μετά την επιλογή συγκεκριμένου Φορέα.
          </td>
          <?php }else { ?>
           <td>
            Στην λίστα εμφανίζονται μόνο οι Τελικοί Υπογράφοντες οι οποίοι έχουν πραγματοποιήσει αναρτήσεις αποφάσεων.
          </td>
          <?php }; ?>
        </tr>
        <tr><td class="topicSpacing"></td></tr>
      </tbody>
    </table>

    <br/>
    <br/>
    <br/>
  </body>
</html>

<?php

namespace Caesar\AdminBundle\Controller;

use Caesar\TagBundle\Entity\Format;
use Caesar\TagBundle\Entity\Tag;
use Caesar\TagBundle\Form\FormatListType;
use Caesar\TagBundle\Form\TagFormattingType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TagController extends Controller {

    /**
     * Action permettant de lister les étiquettes encore non-utilisées
     * @param type $page
     * @param type $sort
     * @param type $direction
     * @return type
     */
    public function indexAction($page = 1, $sort = 'code', $direction = 'asc') {
        $nb_per_page = 10; // Nombre d'éléments affichés par page (pour la pagination)
        $em = $this->getDoctrine()->getManager();

        $repository_tag = $em->getRepository('CaesarTagBundle:Tag');

        $request = $this->get('request');
        $tags = $repository_tag->getTagFromToSortBy($page, $sort, $direction);
        $count = $repository_tag->count();

        /* Pagination */
        $total = $count;
        $pagination = array(
            'cur' => $page,
            'max' => floor($total / $nb_per_page),
        );

        $array = array(
            'tags' => $tags,
            'page' => $page,
            'sort' => $sort,
            'direction' => $direction,
            'count' => $count,
            'pagination' => $pagination);

        if ($request->isXmlHttpRequest()) {
            return $this->render("CaesarAdminBundle:Tag:list.html.twig", $array);
        }

        return $this->render("CaesarAdminBundle:Tag:index.html.twig", $array);
    }

    /**
     * Action permettant de générer et d'afficher les étiquettes à imprimer
     * @return type
     */
    public function generateAction() {
        $format = new Format();
        $listForm = $this->createForm(new FormatListType());

        $request = $this->get('request');
        if ($request->isMethod('POST')) {
            $listForm->bind($request);
            if ($listForm->isValid()) {
                $data = $listForm->getData();
                $format = $data['format'];

                $em = $this->getDoctrine()->getEntityManager();
                $number = $format->getColumns() * $format->getRows();
                $tags = array();
                $xml = simplexml_load_file($this->get('kernel')->getRootDir() . '/../src/Caesar/AdminBundle/Resources/config/params.xml');       
                $nextTagCode = (int) $xml->tag_code_value;
                for ($i = 0; $i < $number; $i++) {
                    $tag = new Tag();

                    $zerosToAdd = 12 - strlen($nextTagCode);
                    $code = 'C-';
                    for ($j = 0; $j < $zerosToAdd; $j++) {
                        $code .= "0";
                    }
                    $tag->setCode($code . $nextTagCode);
                    $nextTagCode = $nextTagCode + 1;
                    $em->persist($tag);
                    array_push($tags, $tag);
                }
                $xml->tag_code_value = $nextTagCode;
                $xml->asXML($this->get('kernel')->getRootDir() . '/../src/Caesar/AdminBundle/Resources/config/params.xml');
                /*$this->get('caesar.params')->save(
                        array(
                            'tag_code_value' => $nextTagCode
                ));*/
                unset($xml);
                $em->flush();

                $em->flush();
                $hgap = $format->getHorizontalGap() - $format->getWidth();
                $vgap = $format->getVerticalGap() - $format->getHeight();
                $pageWidth = $format->getMarginLeft() + (($format->getColumns() - 1) * $hgap) + ($format->getColumns() * $format->getWidth());
                return $this->render("CaesarAdminBundle:Tag:barcodes.html.twig", array('tags' => $tags, 'format' => $format,
                            'hgap' => $hgap, 'vgap' => $vgap, 'pagewidth' => $pageWidth));
            }
        }
        return $this->render('CaesarAdminBundle:Tag:generate.html.twig', array('listForm' => $listForm->createView()));
    }

    /**
     * Action permettant de générer un code-barre à partir d'une chaîne de caractère
     * @param type $text
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function barcodeAction($text) {
        $response = new Response();
        $response->headers->set('Content-Type', 'image/png');

        $size = "40";
        $code_string = "";

        $chksum = 104;
        $code_array = array(" " => "212222", "!" => "222122", "\"" => "222221", "#" => "121223", "$" => "121322", "%" => "131222", "&" => "122213", "'" => "122312", "(" => "132212", ")" => "221213", "*" => "221312", "+" => "231212", "," => "112232", "-" => "122132", "." => "122231", "/" => "113222", "0" => "123122", "1" => "123221", "2" => "223211", "3" => "221132", "4" => "221231", "5" => "213212", "6" => "223112", "7" => "312131", "8" => "311222", "9" => "321122", ":" => "321221", ";" => "312212", "<" => "322112", "=" => "322211", ">" => "212123", "?" => "212321", "@" => "232121", "A" => "111323", "B" => "131123", "C" => "131321", "D" => "112313", "E" => "132113", "F" => "132311", "G" => "211313", "H" => "231113", "I" => "231311", "J" => "112133", "K" => "112331", "L" => "132131", "M" => "113123", "N" => "113321", "O" => "133121", "P" => "313121", "Q" => "211331", "R" => "231131", "S" => "213113", "T" => "213311", "U" => "213131", "V" => "311123", "W" => "311321", "X" => "331121", "Y" => "312113", "Z" => "312311", "[" => "332111", "\\" => "314111", "]" => "221411", "^" => "431111", "_" => "111224", "\`" => "111422", "a" => "121124", "b" => "121421", "c" => "141122", "d" => "141221", "e" => "112214", "f" => "112412", "g" => "122114", "h" => "122411", "i" => "142112", "j" => "142211", "k" => "241211", "l" => "221114", "m" => "413111", "n" => "241112", "o" => "134111", "p" => "111242", "q" => "121142", "r" => "121241", "s" => "114212", "t" => "124112", "u" => "124211", "v" => "411212", "w" => "421112", "x" => "421211", "y" => "212141", "z" => "214121", "{" => "412121", "|" => "111143", "}" => "111341", "~" => "131141", "DEL" => "114113", "FNC 3" => "114311", "FNC 2" => "411113", "SHIFT" => "411311", "CODE C" => "113141", "FNC 4" => "114131", "CODE A" => "311141", "FNC 1" => "411131", "Start A" => "211412", "Start B" => "211214", "Start C" => "211232", "Stop" => "2331112");
        $code_keys = array_keys($code_array);
        $code_values = array_flip($code_keys);
        for ($X = 1; $X <= strlen($text); $X++) {
            $activeKey = substr($text, ($X - 1), 1);
            $code_string .= $code_array[$activeKey];
            $chksum = ($chksum + ($code_values[$activeKey] * $X));
        }
        $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

        $code_string = "211214" . $code_string . "2331112";

        // Pad the edges of the barcode
        $code_length = 0;
        for ($i = 1; $i <= strlen($code_string); $i++) {
            $code_length = $code_length + (integer) (substr($code_string, ($i - 1), 1));
        }
        $img_width = $code_length;
        $img_height = $size;

        $image = imagecreate($img_width, $img_height);
        $black = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $white);
        $location = 0;
        for ($position = 1; $position <= strlen($code_string); $position++) {
            $cur_size = $location + (substr($code_string, ($position - 1), 1) );
            imagefilledrectangle($image, $location, 0, $cur_size, $img_height, ($position % 2 == 0 ? $white : $black));
            $location = $cur_size;
        }
        ob_start();
        imagepng($image);
        $imagevariable = ob_get_contents();
        ob_end_clean();
        $response->setContent($imagevariable);
        imagedestroy($image);
        return $response;
    }

    /**
     * Action permettant de supprimer une étiquette de la base si jamais on a perdu la plaquette d'étiquette par exemple
     *
     * @param type $id
     * @return type
     * @throws type
     */
    public function deleteAction($id) {
        $translator = $this->get('translator');
        if (filter_input(INPUT_GET, $id, FILTER_VALIDATE_INT) !== false) {
            $clean = $id;
        } else {
            throw $this->createNotFoundException($translator->trans('admin.form.tags.exception', array('%tag%' => $id)));
        }
        $em = $this->getDoctrine()->getManager();
        if (isset($clean)) {
            $tag = $em->getRepository('CaesarTagBundle:Tag')->find($clean);
        }
        if (!$tag) {
            throw $this->createNotFoundException($translator->trans('admin.form.tags.exception', array('%tag%' => $id)));
        }
        $em->remove($tag);
        $em->flush();
        $this->get('session')->getFlashBag()->add(
                'notice', $translator->trans('admin.form.tags.notice.delete', array('%tag%' => $tag->getCode()))
        );
        return $this->render('CaesarAdminBundle:Tag:delete.html.twig');
    }

    /**
     * Action permettant l'ajout d'un format
     * @return type
     */
    public function formatAddAction() {
        $translator = $this->get('translator');
        $format = new Format();
        $form = $this->createForm(new TagFormattingType(), $format);

        $listForm = $this->createForm(new FormatListType());

        $request = $this->get('request');
        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $repository = $em->getRepository('CaesarTagBundle:Format');
                $f = $repository->findOneByCode($format->getCode());

                if (!$f) {
                    $em->persist($format);
                    $this->get('session')->getFlashBag()->add(
                            'notice', $translator->trans('admin.validation.tag.format.added')
                    );
                } else {
                    $f->setColumns($format->getColumns());
                    $f->setHeight($format->getHeight());
                    $f->setHorizontalGap($format->getHorizontalGap());
                    $f->setMarginLeft($format->getMarginLeft());
                    $f->setMarginTop($format->getMarginTop());
                    $f->setRows($format->getRows());
                    $f->setVerticalGap($format->getVerticalGap());
                    $f->setWidth($format->getWidth());
                    $this->get('session')->getFlashBag()->add(
                            'notice', $translator->trans('admin.validation.tag.format.updated')
                    );
                }
                $em->flush();
                return $this->redirect($this->generateUrl('caesar_admin_tag_generate'));
            }
        }
        return $this->render('CaesarAdminBundle:Tag:format.html.twig', array('form' => $form->createView(), 'listForm' => $listForm->createView()));
    }

    /**
     * Action permettant de récupérer un format au format JSON
     *
     * @param type $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws type
     */
    public function formatAjaxAction($id = 1) {
        $translator = $this->get('translator');
        if (filter_input(INPUT_GET, $id, FILTER_VALIDATE_INT) !== false) {
            $clean = $id;
        } else {
            throw $this->createNotFoundException($translator->trans('admin.form.format.exception', array('%format%' => $id)));
        }

        $em = $this->getDoctrine()->getManager();
        if (isset($clean)) {
            $format = $em->getRepository('CaesarTagBundle:Format')
                    ->find($clean);
        }
        if (!$format) {
            throw $this->createNotFoundException($translator->trans('admin.form.format.exception', array('%format%' => $clean)));
        }

        $request = $this->get('request');
        if ($request->isXmlHttpRequest()) {
            return new Response(json_encode($format->getJsonData()));
        }
        throw $this->createNotFoundException($translator->trans('admin.form.invalid'));
    }

}
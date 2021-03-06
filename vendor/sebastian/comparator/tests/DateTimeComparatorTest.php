INDX( 	 LF�             (   �  �        p                   �'     p \     �'     �XH�pk� =^���ٽ��<��XH�pk�       �               C h u n k T e s t . p h p     �'     p ^     �'     &M�pk� =^���ٽ��<�&M�pk� 0      �.               D i f f e r T e s t . p h p   �'     p Z     �'     �DT�pk� =^����:���<��DT�pk�       u               D i f f T e s t . p h p       �'     h T     �'     �Wg�pk��
C^%��Wg�pk��Wg�pk�                       	 E x c e p t i o n p h �'     h R     �'     �Cs�pk��U��pk��U��pk��U��pk�                        f i x t u r e s . p h �'     p Z     �'     �	Y�pk� =^����:���<��	Y�pk�       �               L i n e T e s t . p h p       �'     � �     �'     �k[�pk� =^���ŝ¶�<��k[�pk�        �                L o n g e s t C o m m o n S u b s e q u e n c e T e s t . p h p       �'     � �     �'     D�]�pk� =^���ŝ¶�<�D�]�pk��                    % M e m o r y E f f i c i e n t I m p l e m e n t a t i o n T e s t .  h p     �'     ` N     �'     �}��pk��,��pk��,��pk��,��pk�                        O u t p u t T �'     p ^     �'     �b�pk� =^���z�Ķ�<��b�pk�                       P a r s e r T e s t . p h p   �'     � �     �'     ��d�pk� =^���z�Ķ�<���d�pk��      y              # T i m e E f f i c i e n t I m p l e m e n t a t i o n T e s t . p h p �'     ` L     �'     �ɧpk����C^%��ɧpk��ɧpk�                        U t i l s                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             <?php declare(strict_types=1);
/*
 * This file is part of sebastian/diff.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SebastianBergmann\Diff;

use PHPUnit\Framework\TestCase;
use SebastianBergmann\Diff\Utils\FileUtils;

/**
 * @covers SebastianBergmann\Diff\Parser
 *
 * @uses SebastianBergmann\Diff\Chunk
 * @uses SebastianBergmann\Diff\Diff
 * @uses SebastianBergmann\Diff\Line
 */
final class ParserTest extends TestCase
{
    /**
     * @var Parser
     */
    private $parser;

    protected function setUp(): void
    {
        $this->parser = new Parser;
    }

    public function testParse(): void
    {
        $content = FileUtils::getFileContent(__DIR__ . '/fixtures/patch.txt');

        $diffs = $this->parser->parse($content);

        $this->assertContainsOnlyInstancesOf(Diff::class, $diffs);
        $this->assertCount(1, $diffs);

        $chunks = $diffs[0]->getChunks();
        $this->assertContainsOnlyInstancesOf(Chunk::class, $chunks);

        $this->assertCount(1, $chunks);

        $this->assertSame(20, $chunks[0]->getStart());

        $this->assertCount(4, $chunks[0]->getLines());
    }

    public function testParseWithMultipleChunks(): void
    {
        $content = FileUtils::getFileContent(__DIR__ . '/fixtures/patch2.txt');

        $diffs = $this->parser->parse($content);

        $this->assertCount(1, $diffs);

        $chunks = $diffs[0]->getChunks();
        $this->assertCount(3, $chunks);

        $this->assertSame(20, $chunks[0]->getStart());
        $this->assertSame(320, $chunks[1]->getStart());
        $this->assertSame(600, $chunks[2]->getStart());

        $this->assertCount(5, $chunks[0]->getLines());
        $this->assertCount(5, $chunks[1]->getLines());
        $this->assertCount(4, $chunks[2]->getLines());
    }

    public function testParseWithRemovedLines(): void
    {
        $content = <<<END
diff --git a/Test.txt b/Test.txt
index abcdefg..abcdefh 100644
--- a/Test.txt
+++ b/Test.txt
@@ -49,9 +49,8 @@
 A
-B
END;
        $diffs = $this->parser->parse($content);
        $this->assertContainsOnlyInstancesOf(Diff::class, $diffs);
        $this->assertCount(1, $diffs);

        $chunks = $diffs[0]->getChunks();

        $this->assertContainsOnlyInstancesOf(Chunk::class, $chunks);
        $this->assertCount(1, $chunks);

        $chunk = $chunks[0];
        $this->assertSame(49, $chunk->getStart());
        $this->assertSame(49, $chunk->getEnd());
        $this->assertSame(9, $chunk->getStartRange());
        $this->assertSame(8, $chunk->getEndRange());

        $lines = $chunk->getLines();
        $this->assertContainsOnlyInstancesOf(Line::class, $lines);
        $this->assertCount(2, $lines);

        /** @var Line $line */
        $line = $lines[0];
        $this->assertSame('A', $line->getContent());
        $this->assertSame(Line::UNCHANGED, $line->getType());

        $line = $lines[1];
        $this->assertSame('B', $line->getContent());
        $this->assertSame(Line::REMOVED, $line->getType());
    }

    public func
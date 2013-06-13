import sys
import xml.etree.ElementTree as ET


def mathmlToSage(mathml):
    root = ET.XML(mathml)
    if not 'math' in root.tag:
        raise "MathML must begin with <math> tag"
    return parse_element(root)


def parse_element(element):
    result = ''
    tag = element.tag
    namespace_end = tag.rfind('}')
    if namespace_end != -1:
        tag = tag[namespace_end + 1:]
    parse_method = 'parse_' + tag
    if parse_method in dir(sys.modules[__name__]):
        return getattr(sys.modules[__name__], parse_method)(element)

    for child in element:
        result = result + parse_element(child)

    return result


def parse_mi(mi):
    return '(' + mi.text + ')'


def parse_mo(mo):
    return mo.text


def parse_mn(mn):
    return '(' + mn.text + ')'


def parse_mfrac(mfrac):
    children = list(mfrac)
    if len(children) != 2:
        raise "<mfrac> element must contain two children"
    result = '(' + parse_element(children[0]) + ')/('
    result = result + parse_element(children[1]) + ')'
    return result


def parse_msup(msup):
    children = list(msup)
    if len(children) != 2:
        raise "<msup> element must contain two children"
    result = '((' + parse_element(children[0]) + ')^('
    result = result + parse_element(children[1]) + '))'
    return result


def parse_msqrt(msqrt):
    result = 'sqrt('
    for child in msqrt:
        result = result + parse_element(child)
    result = result + ')'
    return result

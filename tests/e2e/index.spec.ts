import {expect, test} from '@playwright/test';
import common from './common';

test('The index page loads', async ({ page, context }) => {
    await page.goto(`${common.appUrl}`);
    await expect(page.getByRole('heading', { name: 'mmbd.io' })).toBeVisible();
});

test('The how it works link is shown and redirects to correct page', async ({page}) => {
    await page.goto(`${common.appUrl}`);
    await expect(page.getByRole('link', { name: 'How it works' })).toBeVisible()
    await page.getByRole('link', { name: 'How it works' }).click()
    await page.waitForURL('**/how-it-works', {
        waitUntil: 'domcontentloaded',
    });
    await expect(page.getByText('How it works')).toBeVisible()
})
